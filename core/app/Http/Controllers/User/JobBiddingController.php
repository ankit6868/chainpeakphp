<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobBid;
use Illuminate\Http\Request;

class JobBiddingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'job_id'      => 'required|integer|gt:0',
            'title'       => 'required|max:40',
            'price'       => 'required|numeric|gt:0',
            'description' => 'required',
        ]);

        $job = Job::where('id', $request->job_id)->active()->userActiveCheck()->checkData()->firstOrFail();

        if ($job->user_id == auth()->id()) {
            $notify[] = ['error', 'You have posted this job'];
            return back()->withNotify($notify);
        }

        $existingJobBidCheck = JobBid::where('job_id', $job->id)->where('user_id', auth()->id())->first();

        if ($existingJobBidCheck) {
            $notify[] = ['error', 'You have already made a bid on this job'];
            return back()->withNotify($notify);
        }

        $job->total_bid += 1;
        $job->save();

        $jobBidding              = new JobBid();
        $jobBidding->user_id     = auth()->id();
        $jobBidding->buyer_id    = $job->user_id;
        $jobBidding->job_id      = $job->id;
        $jobBidding->title       = $request->title;
        $jobBidding->price       = $request->price;
        $jobBidding->description = $request->description;
        $jobBidding->save();

        $notify[] = ['success', 'You bid has been taken successfully'];
        return back()->withNotify($notify);
    }
}
