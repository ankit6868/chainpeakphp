<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Job;
use App\Models\Reply;
use App\Models\Service;
use App\Models\Software;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|gt:0',
            'type'       => 'required|in:service,software,job',
            'comment'    => 'required',
        ]);

        $serviceId  = 0;
        $softwareId = 0;
        $jobId      = 0;

        if ($request->type == 'service') {
            $product   = Service::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $serviceId = $product->id;
        } elseif ($request->type == 'software') {
            $product    = Software::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $softwareId = $product->id;;
        } else {
            $product = Job::where('id', $request->product_id)->active()->userActiveCheck()->checkData()->firstOrFail();
            $jobId   = $product->id;
        }

        $comment              = new Comment();
        $comment->user_id     = auth()->id();
        $comment->service_id  = $serviceId;
        $comment->software_id = $softwareId;
        $comment->job_id      = $jobId;
        $comment->comment     = $request->comment;
        $comment->save();

        $notify[] = ['success','Your Comment has been taken successfully'];
        return back()->withNotify($notify);
    }

    public function replyStore(Request $request)
    {
        $request->validate([
            'comment_id' => 'required',
            'reply'      => 'required',
        ]);

        $comment = Comment::where('id', decrypt($request->comment_id))->firstOrFail();

        $reply             = new Reply();
        $reply->user_id    = auth()->id();
        $reply->comment_id = $comment->id;
        $reply->reply      = $request->reply;
        $reply->save();

        $notify[] = ['success','Your reply has been taken successfully'];
        return back()->withNotify($notify);
    }
}
