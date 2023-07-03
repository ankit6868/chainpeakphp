<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Transaction;
use App\Models\WorkFile;

class ManageJobController extends Controller
{
    public  $pageTitle;

    protected function jobData($scope = null)
    {
        if ($scope) {
            $jobs = Job::$scope();
        }else{
            $jobs = Job::query();
        }
        $jobs = $jobs->searchable(['name', 'user:username', 'category:name', 'subCategory:name'])->filter(['user_id'])->latest()->with(['user', 'category', 'subCategory'])->paginate(getPaginate());
        $pageTitle = $this->pageTitle . ' Jobs';
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }

    public function all()
    {
        $this->pageTitle  = 'All';
        return $this->jobData(null);
    }

    public function pending()
    {
        $this->pageTitle  = 'Pending';
        return $this->jobData('pending');
    }

    public function approved()
    {
        $this->pageTitle  = 'Approved';
        return $this->jobData('approved');
    }

    public function canceled()
    {
        $this->pageTitle  = 'Canceled';
        return $this->jobData('canceled');
    }

    public function closed()
    {
        $this->pageTitle  = 'Closed';
        return $this->jobData('closed');
    }

    public function statusChange($id, $type)
    {
        $job = Job::where('id', $id)->where('status', Status::PENDING)->firstOrFail();

        if ($type == 'approve') {
            $notification = 'approved';
            $job->status  = Status::APPROVED;
        } else {
            $notification = 'canceled';
            $job->status  = Status::CANCELED;
        }

        $job->updated_at = now();
        $job->save();

        $notify[] = ['success', "Job $notification successfully"];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $pageTitle = 'Job Details';
        $job       = Job::with('user')->findOrFail($id);
        return view('admin.job.details', compact('pageTitle', 'job'));
    }

    public function biddingList($id)
    {
        $job         = Job::where('id', $id)->where('status', '!=', Status::PENDING)->firstOrFail();
        $biddingList = JobBid::where('job_id', $job->id)->latest()->with('user')->paginate(getPaginate());
        $pageTitle   = 'Bidding List';
        return view('admin.job.bidding_list', compact('pageTitle', 'biddingList'));
    }

    protected function hiringData($scope = null)
    {
        $biddingList = JobBid::query();

        if ($scope) {
            $biddingList = $biddingList->$scope();
        }

        $biddingList = $biddingList->latest()->with(['job', 'user', 'buyer'])->paginate(getPaginate());
        $pageTitle   = $this->pageTitle . ' Hiring';

        return view('admin.job.bidding_list', compact('pageTitle', 'biddingList'));
    }

    public function hiringCompleted()
    {
        $this->pageTitle  = 'Completed';
        return $this->hiringData('completed');
    }

    public function hiringDelivered()
    {
        $this->pageTitle  = 'Delivered';
        return $this->hiringData('delivered');
    }

    public function hiringInprogress()
    {
        $this->pageTitle  = 'Inprogress';
        return $this->hiringData('inprogress');
    }

    public function hiringDisputed()
    {
        $this->pageTitle  = 'Disputed';
        return $this->hiringData('disputed');
    }

    public function hiringCanceled()
    {
        $this->pageTitle  = 'Canceled';
        return $this->hiringData('canceled');
    }

    public function hiringExpired()
    {
        $this->pageTitle  = 'Expired';
        return $this->hiringData('expired');
    }

    public function hiringDetails($id)
    {

        $pageTitle = 'Hiring Details';
        $details   = JobBid::with(['job', 'user', 'buyer', 'disputer'])->findOrFail($id);

        $workFiles     = WorkFile::where('job_bid_id', $details->id)->latest()->with(['sender', 'receiver'])->get();
        $chats         = Chat::where('job_bid_id', $details->id)->with('user')->get();

        return view('admin.job.bidding_details', compact('pageTitle', 'details', 'workFiles', 'chats'));
    }

    public function winBidder($id)
    {
        $jobBid = JobBid::where('working_status', Status::WORKING_DISPUTED)->with('user')->findOrFail($id);
        $jobBid->working_status = Status::WORKING_COMPLETED;
        $jobBid->updated_at     = now();
        $jobBid->save();

        $jobBid->user->balance += $jobBid->price;
        $jobBid->user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $jobBid->user->id;
        $transaction->amount       = $jobBid->price;
        $transaction->post_balance = $jobBid->user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added for completed a job named ' . $jobBid->job->name . ' by system';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_completed';
        $transaction->save();

        $chat             = new Chat();
        $chat->job_bid_id = $jobBid->id;
        $chat->admin      = 1;
        $chat->message    = 'System marked bidder as winner';
        $chat->save();

        $emailShortCodes = [
            'winner_username' => $jobBid->user->username,
            'product_type'    => 'Job',
            'product_name'    => $jobBid->job->name,
            'message'         => 'System decided that the bidder is the winner'
        ];

        notify($jobBid->user, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);
        notify($jobBid->buyer, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);

        $notify[] = ['success', 'Amount given to the bidder successfully'];
        return back()->withNotify($notify);
    }

    public function winBuyer($id)
    {
        $jobBid = JobBid::where('working_status', Status::WORKING_DISPUTED)->with('buyer')->findOrFail($id);

        $jobBid->status         = Status::CANCELED;
        $jobBid->working_status = null;
        $jobBid->updated_at     = now();
        $jobBid->save();

        $jobBid->buyer->balance += $jobBid->price;
        $jobBid->buyer->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $jobBid->buyer->id;
        $transaction->amount       = $jobBid->price;
        $transaction->post_balance = $jobBid->buyer->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added as refund for hiring a bidder and the job name was ' . $jobBid->job->name . ' by system';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_canceled';
        $transaction->save();

        $chat = new Chat();
        $chat->booking_id = $jobBid->id;
        $chat->admin      = 1;
        $chat->message    = 'System marked buyer as winner';
        $chat->save();

        $emailShortCodes = [
            'winner_username' => $jobBid->buyer->username,
            'product_type'    => 'Job',
            'product_name'    => $jobBid->job->name,
            'message'         => 'System decided that the buyer is the winner'
        ];

        notify($jobBid->user, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);
        notify($jobBid->buyer, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);

        $notify[] = ['success', 'Amount returned to the buyer successfully'];
        return back()->withNotify($notify);
    }
}
