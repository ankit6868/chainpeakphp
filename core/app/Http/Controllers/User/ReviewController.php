<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:service,software',
            'booking_id' => 'required',
            'product_id' => 'required|integer|gt:0',
            'like'       => 'required|in:1,0',
            'rating'     => 'required|integer|min:1|max:5',
        ]);

        $booking    = null;
        $type       = $request->type;
        $user       = auth()->user();
        $serviceId  = 0;
        $softwareId = 0;
        $toUserId   = 0;

        if ($type == 'service') {
            $booking  = Booking::where('id', decrypt($request->booking_id))->where('service_id', $request->product_id)->where('buyer_id', $user->id)->where('working_status', Status::WORKING_COMPLETED)->where('review_status', Status::NO)->with(['service', 'service.user'])->first();
        } else {
            $booking  = Booking::where('id', decrypt($request->booking_id))->where('software_id', $request->product_id)->where('buyer_id', $user->id)->where('status', Status::BOOKING_PAID)->where('review_status', Status::NO)->with(['software', 'software.user'])->first();
        }

        if (!$booking) {
            $notify[] = ['error','You are not allowed to make this review'];
            return back()->withNotify($notify);
        }

        if ($type == 'service') {
            if ($request->like) {
                $booking->service->likes += 1;
            } else {
                $booking->service->dislike += 1;
            }

            $serviceId = $booking->service->id;
            $toUserId  = $booking->service->user->id;

            $booking->service->total_review += 1;
            $booking->service->total_rating += $request->rating;
            $booking->service->save();

            $booking->service->user->total_review += 1;
            $booking->service->user->total_rating += $request->rating;
            $booking->service->user->save();
        } else {
            if ($request->like) {
                $booking->software->likes += 1;
            } else {
                $booking->software->dislike += 1;
            }

            $softwareId = $booking->software->id;
            $toUserId   = $booking->software->user->id;

            $booking->software->total_review += 1;
            $booking->software->total_rating += $request->rating;
            $booking->software->save();

            $booking->software->user->total_review += 1;
            $booking->software->user->total_rating += $request->rating;
            $booking->software->user->save();
        }

        $booking->review_status = Status::YES;
        $booking->save();

        $review              = new Review();
        $review->user_id     = $user->id;
        $review->to_id       = $toUserId;
        $review->service_id  = $serviceId;
        $review->software_id = $softwareId;
        $review->rating      = $request->rating;
        $review->review      = $request->review;

        if ($request->like) {
            $review->like_dislike = 1;
        } else {
            $review->like_dislike = 0;
        }

        $review->save();

        $notify[] = ['success','Your review has been taken successfully'];
        return back()->withNotify($notify);
    }
}
