<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\JobBid;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id'      => 'required',
            'type'    => 'required|in:service,job',
            'message' => 'required',
            'file'    => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf']), 'max:2000'],
        ]);

        $user      = auth()->user();
        $bookingId = 0;
        $jobBidId  = 0;
        $file      = null;

        if ($request->type == 'service') {
            $data = Booking::where('id', decrypt($request->id))->where('service_id', '!=', 0)->where('working_status', Status::WORKING_DISPUTED)->where(function($checkUser) use ($user) {
                        $checkUser->where('seller_id', $user->id)->orWhere('buyer_id', $user->id);
                    })->firstOrFail();

            $bookingId = $data->id;
            
        } else {
            $data = JobBid::where('id', decrypt($request->id))->where('working_status', Status::WORKING_DISPUTED)->where(function ($checkUser) use ($user) {
                        $checkUser->where('user_id', $user->id)->orWhere('buyer_id', $user->id);
                    })->firstOrFail();

            $jobBidId = $data->id;
        }

        if ($request->hasFile('file')) {
            $file = fileUploader($request->file, getFilePath('chatFile'));
        }

        $chat = new Chat();
        $chat->booking_id = $bookingId;
        $chat->job_bid_id = $jobBidId;
        $chat->user_id    = $user->id;
        $chat->message    = $request->message;
        $chat->file       = $file;
        $chat->save();

        $notify[] = ['success', 'Your response is taken successfully'];
        return back()->withNotify($notify);
    }
}
