<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Form;
use App\Models\JobBid;
use App\Models\Service;
use App\Models\Software;
use App\Models\Transaction;
use App\Models\WorkFile;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return to_route('user.seller.home');
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits  = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general   = gs();
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle    = 'Transactions';
        $remarks      = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id',auth()->id())->searchable(['trx'])->filter(['trx_type','remark'])->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'user.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error','Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error','You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act','kyc')->first();
        return view($this->activeTemplate.'user.kyc.form', compact('pageTitle','form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate.'user.kyc.info', compact('pageTitle','user'));
    }

    public function kycSubmit(Request $request)
    {
        $form           = Form::where('act','kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData       = $formProcessor->processFormData($request, $formData);
        $user           = auth()->user();
        $user->kyc_data = $userData;
        $user->kv       = 2;
        $user->save();

        $notify[] = ['success','KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name).'- attachments.'.$extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'user.user_data', compact('pageTitle','user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname'=>'required|max:40',
            'lastname' =>'required|max:40',
            'about_me' =>'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->about_me  = $request->about_me;
        $user->address   = [
            'country'=>@$user->address->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
        ];
        $user->profile_complete = 1;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function workFileUpload(Request $request, $orderNumberOrJobId)
    {
        $request->validate([
            'work_type' => 'required|in:service,job',
            'details'   => 'required',
            'file'      => ['required', new FileTypeValidate(['zip'])],
        ]);

        $authId    = auth()->id();
        $bookingId = 0;
        $jobBidId  = 0;

        if ($request->work_type == 'service') {
            $data = Booking::checkServiceBookingData($orderNumberOrJobId)->where('status', Status::APPROVED)->where(function($user) use ($authId) {
                            $user->where('seller_id', $authId)->orWhere('buyer_id', $authId);
                        })->where(function ($q) {
                            $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
                        })->firstOrFail();

            $bookingId = $data->id;

            if ($data->seller_id == $authId) {
                $senderId   = $data->seller_id;
                $receiverId = $data->buyer_id;
            } else {
                $senderId   = $data->buyer_id;
                $receiverId = $data->seller_id;
            }

        } elseif(($request->work_type == 'job')) {

            $data = JobBid::where('id', $orderNumberOrJobId)->where('status', Status::APPROVED)->where(function ($q) use ($authId) {
                        $q->where('user_id', $authId)->orWhere('buyer_id', $authId);
                    })->firstOrFail();

            if ($data->user_id == $authId) {
                $senderId   = $data->user_id;
                $receiverId = $data->buyer_id;
            } else {
                $senderId   = $data->buyer_id;
                $receiverId = $data->user_id;
            }

            $jobBidId = $data->id;

        } else {
            $notify[] = ['error', 'Invalid type of work file submitted'];
            return back()->withNotify($notify);
        }

        $data->working_status = Status::WORKING_DELIVERED;
        $data->updated_at = now();
        $data->save();

        $workFile              = new WorkFile();
        $workFile->booking_id  = $bookingId;
        $workFile->job_bid_id  = $jobBidId;
        $workFile->sender_id   = $senderId;
        $workFile->receiver_id = $receiverId;
        $workFile->file        = fileUploader($request->file, getFilePath('workFile'));
        $workFile->details     = $request->details;
        $workFile->save();

        $notify[] = ['success', 'Work file submitted successfully'];
        return back()->withNotify($notify);
    }

    public function dispute(Request $request, $orderNumberOrBidId)
    {

        $request->validate([
            'dispute_type' => 'required|in:service,job',
            'reason'       => 'required'
        ]);

        $user        = auth()->user();
        $bookingId   = 0;
        $jobBidId    = 0;
        $sendToUser  = null;
        $productType = null;
        $productName = null;

        if ($request->dispute_type == 'service') {
            $data =  Booking::checkServiceBookingData($orderNumberOrBidId)->where(function($checkUser) use ($user) {
                        $checkUser->where('seller_id', $user->id)->orWhere('buyer_id', $user->id);
                    })->where(function ($q) {
                        $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
                    })->firstOrFail();
            $bookingId = $data->id;
        } elseif ($request->dispute_type == 'job') {
            $data = JobBid::where('id', $orderNumberOrBidId)->where(function ($checkUser) use ($user) {
                        $checkUser->where('user_id', $user->id)->orWhere('buyer_id', $user->id);
                    })->where('status', Status::APPROVED)->where(function ($q) {
                        $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
                    })->firstOrFail();

            $jobBidId = $data->id;

        } else {
            $notify[] = ['error', 'Invalid dispute type'];
            return back()->withNotify($notify);
        }

        $data->working_status = Status::WORKING_DISPUTED;
        $data->disputer_id    = $user->id;
        $data->reason         = $request->reason;
        $data->updated_at     = now();
        $data->save();

        $chat             = new Chat();
        $chat->booking_id = $bookingId;
        $chat->job_bid_id = $jobBidId;
        $chat->user_id    = $user->id;
        $chat->message    = 'Disputed by '. $user->username;
        $chat->save();

        if ($bookingId) {
            $sendToUser  = $data->seller_id == $data->disputer_id ? $data->buyer : $data->seller;
            $productType = 'service';
            $productName = $data->service->name;
        }

        if ($jobBidId) {
            $sendToUser  = $data->user_id == $data->disputer_id ? $data->buyer : $data->user;
            $productType = 'job';
            $productName = $data->job->name;
        }

        if ($sendToUser) {
            notify($sendToUser, 'DISPUTED', [
                'disputer_username' => $data->disputer->username,
                'product_type'      => $productType,
                'product_name'      => $productName,
                'reason'            => $request->reason
            ]);
        }

        $notify[] = ['success', 'Disputed successfully. Wait for the system response'];
        return back()->withNotify($notify);
    }

    public function removeExtraImage($id, $imageName, $type)
    {
        if ($type == 'software') {
            $data = Software::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        } elseif ($type == 'service') {
            $data = Service::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $notify[] = ['success', 'Invalid image removal request'];
            return back()->withNotify($notify);
        }

        $extraImage = [];
        $imageCheck = in_array($imageName, $data->extra_image);

        if (!$imageCheck) {
            $notify[] = ['error', 'Image not found'];
            return back()->withNotify($notify);
        }

        foreach ($data->extra_image as $singleImage) {
            if ($singleImage != $imageName) {
                $extraImage[] = $singleImage;
            }
        }

        $data->extra_image = $extraImage;
        $data->save();

        fileManager()->removeFile(getFilePath('extraImage'). '/' .$imageName);

        $notify[] = ['success', 'Image removed successfully'];
        return back()->withNotify($notify);
    }
}
