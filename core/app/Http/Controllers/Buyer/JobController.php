<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Job;
use App\Models\Chat;
use App\Models\JobBid;
use App\Models\Category;
use App\Models\WorkFile;
use App\Constants\Status;
use App\Models\SubCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Job';
        $jobs      = Job::where('user_id', auth()->id())->latest()->with('category')->paginate(getPaginate());
        return view($this->activeTemplate . 'buyer.job.index', compact('pageTitle', 'jobs'));
    }

    public function new()
    {
        $pageTitle  = 'New Job';
        $categories = Category::active()->orderBy('name')->with('subCategories',function($q){
            $q->active();
        })->get();
        return view($this->activeTemplate . 'buyer.job.new', compact('pageTitle', 'categories'));
    }

    public function edit($slug, $id)
    {

        $pageTitle  = 'Edit Job';
        $job        = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $categories = Category::orderBy('name')->get()->map(function ($category) {
            $subcategories = SubCategory::where('category_id', $category->id)->get();
            $category['subcategories'] = $subcategories;
            return $category;
        });
        return view($this->activeTemplate . 'buyer.job.edit', compact('pageTitle', 'categories', 'job'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->jobValidation($request, $id);
        $check = $this->checkData($request, $id);

        if ($check[0] == 'error') {
            $notify[] = $check;
            return back()->withNotify($notify);
        }
        if ($id) {
            $job          = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            $notification = 'Job updated successfully';
        } else {
            $job          = new Job();
            $job->user_id = auth()->id();
            $notification     = 'Job added successfully';
        }

        if ($request->hasFile('image')) {
            $jobImage   = fileUploader($request->image, getFilePath('job'), getFileSize('job'), @$job->image);
            $job->image = $jobImage;
        }

        if(gs()->post_approval) {
            $job->status = Status::ENABLE;
        }

        $job->name            = $request->name;
        $job->price           = $request->price;
        $job->skill           = $request->skill;
        $job->description     = $request->description;
        $job->category_id     = $request->category_id;
        $job->requirements    = $request->requirements;
        $job->delivery_time   = $request->delivery_time;
        $job->sub_category_id = $request->sub_category_id;
        $job->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function close($id)
    {
        $job             = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $job->status     = Status::CLOSED;
        $job->updated_at = now();
        $job->save();

        $notify[] = ['success', 'Job is closed successfully'];
        return back()->withNotify($notify);
    }

    public function biddingList($slug, $id)
    {
        $pageTitle   = 'Job Bidding List';
        $job         = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $biddingList = JobBid::where('job_id', $job->id)->where('buyer_id', auth()->id())->where('status', '!=', Status::APPROVED)->latest()->with('user')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.job.job_hiring', compact('pageTitle', 'biddingList'));
    }

    public function bidApprove($id)
    {
        $user = auth()->user();
        $bid  = JobBid::where('id', $id)->where('buyer_id', $user->id)->where('status', Status::PENDING)->firstOrFail();

        if ($bid->price > $user->balance) {
            $notify[] = ['success', 'You don\'t have enough balance to hire this bidder'];
            return back()->withNotify($notify);
        }

        $user->balance -= $bid->price;
        $user->save();

        $bid->status         = Status::APPROVED;
        $bid->working_status = Status::WORKING_INPROGRESS;
        $bid->updated_at     = now();
        $bid->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $bid->price;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Payment for hiring a bidder for a job';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_hiring';
        $transaction->save();

        notify($bid->user, 'EMPLOYEE_HIRED', [
            'buyer_username' => $user->username,
            'job_name'       => $bid->job->name,
            'budget'         => showAmount($bid->price).' '.gs()->cur_text,
            'delivery_time'  => showDateTime($bid->created_at->addDays($bid->job->delivery_time), ('M, d - Y'))
        ]);

        $notify[] = ['success', 'This bid is approved successfully'];
        return back()->withNotify($notify);
    }

    public function bidCancel($id)
    {
        $bid                 = JobBid::where('id', $id)->where('buyer_id', auth()->id())->where('status', Status::PENDING)->firstOrFail();
        $bid->status         = Status::CANCELED;
        $bid->working_status = null;
        $bid->updated_at     = now();
        $bid->save();

        notify($bid->user, 'BID_CANCELED', [
            'buyer_username' => auth()->user()->username,
            'job_name'       => $bid->job->name,
            'budget'         => showAmount($bid->price).' '.gs()->cur_text
        ]);

        $notify[] = ['success', 'This bid is canceled successfully'];
        return back()->withNotify($notify);
    }

    public function hiringList()
    {
        $pageTitle  = 'Hiring List';
        $biddingList = JobBid::where('buyer_id', auth()->id())->where('status', Status::APPROVED)->latest()->with('user')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.job.job_hiring', compact('pageTitle', 'biddingList'));
    }

    public function hiringDetails($id)
    {
        // return Category::where('status',1)->append('name','121')->get();

        $pageTitle = 'Hiring Details';
        $details   = JobBid::where('id', $id)->where('buyer_id', auth()->id())->with(['job', 'disputer'])->firstOrFail();
        $workFiles = WorkFile::where('job_bid_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());
        $chats     = Chat::where('job_bid_id', $details->id)->with('user')->get();

        return view($this->activeTemplate . 'user.job.details', compact('pageTitle', 'details', 'workFiles', 'chats'));
    }

    public function hiringCompleted(Request $request, $id)
    {
        $bid =  JobBid::where('id', $id)->where('buyer_id', auth()->id())->where('status', Status::APPROVED)->where(function ($q) {
                    $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
                })->with('user')->firstOrFail();

        $bid->working_status = Status::WORKING_COMPLETED;
        $bid->updated_at     = now();
        $bid->save();

        $bid->user->balance += $bid->price;
        $bid->user->earning += $bid->price;
        $bid->user->save();

        userLevel($bid->user);

        $transaction               = new Transaction();
        $transaction->user_id      = $bid->user->id;
        $transaction->amount       = $bid->price;
        $transaction->post_balance = $bid->user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'For completing a job';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_delivered';
        $transaction->save();

        $notify[] = ['success', 'Job marked as completed successfully'];
        return back()->withNotify($notify);
    }

    protected function jobValidation($request, $id)
    {
        $imageValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'image'           => [$imageValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'delivery_time'   => 'required|integer|min:1',
            'skill'           => 'required|array|min:3|max:15',
            'description'     => 'required',
            'requirements'    => 'required',
        ]);
    }

    protected function checkData($request, $id)
    {
        $category    = Category::active();
        $subcategory = SubCategory::active();

        $category = $category->where('id', $request->category_id)->first();

        if (!$category) {
            return ['error', 'Category not found or disabled'];
        } else {
            $subcategory = $subcategory->where('id', $request->sub_category_id)->where('category_id', $category->id)->first();

            if (!$subcategory) {
                return ['error', 'Subcategory not found or disabled'];
            }
        }

        return ['success'];
    }
}
