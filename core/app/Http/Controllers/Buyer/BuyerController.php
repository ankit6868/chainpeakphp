<?php

namespace App\Http\Controllers\Buyer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\ExtraService;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Transaction;
use App\Models\WorkFile;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function home()
    {
        $pageTitle     = 'Buyer Dashboard';
        $authId        = auth()->id();
        $basicTrxQuery = Transaction::where('user_id', $authId);
        $trx           = clone $basicTrxQuery;
        $trxCount      = clone $basicTrxQuery;
        $transactions  = $trx->orderBy('id','desc')->limit(10)->get();
        $totalTrxCount = $trxCount->count();

        $totalJobCount          = Job::where('user_id', $authId)->count();
        $totalBookedService     = Booking::where('service_id', '!=', 0)->where('buyer_id', $authId)->where('status', '!=', Status::BOOKING_UNPAID)->count();
        $totalPurchasedSoftware = Booking::where('software_id', '!=', 0)->where('buyer_id', $authId)->where('status' , '!=', Status::BOOKING_UNPAID)->count();
        $totalHiredEmployee     = JobBid::where('buyer_id', $authId)->where('status', Status::APPROVED)->count();

        return view($this->activeTemplate . 'buyer.dashboard', compact('pageTitle', 'transactions', 'totalTrxCount', 'totalJobCount', 'totalBookedService', 'totalPurchasedSoftware', 'totalHiredEmployee'));
    }

    public function bookedService()
    {
        $pageTitle      = 'Booked Services';
        $bookedServices = Booking::where('service_id', '!=', 0)->where('buyer_id', auth()->id())->where('status', '!=', Status::BOOKING_UNPAID)->with(['service', 'seller'])->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.service.booking_list', compact('pageTitle', 'bookedServices'));
    }

    public function bookedServiceDetails($orderNumber)
    {
        $pageTitle     = 'Booked Service Details';
        $details       = Booking::checkServiceBookingData($orderNumber)->where('buyer_id', auth()->id())->firstOrFail();
        $extraServices = ExtraService::where('service_id', $details->service_id)->find(json_decode($details->extra_services));
        $workFiles     = WorkFile::where('booking_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());
        $chats         = Chat::where('booking_id', $details->id)->with('user')->get();

        return view($this->activeTemplate . 'user.service.booking_details', compact('pageTitle', 'details', 'extraServices', 'workFiles', 'chats'));
    }

    public function serviceCompleted($orderNumber)
    {
        $booking =  Booking::checkServiceBookingData($orderNumber)->where('buyer_id', auth()->id())->where('status', Status::BOOKING_APPROVED)->where(function ($q) {
                        $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
                    })->with('seller')->firstOrFail();

        $booking->working_status = Status::WORKING_COMPLETED;
        $booking->updated_at     = now();
        $booking->save();

        $booking->seller->balance += $booking->final_price;
        $booking->seller->earning += $booking->final_price;
        $booking->seller->save();

        userLevel($booking->seller);

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->seller->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->seller->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'For completing a service';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'service_completed';
        $transaction->save();

        $notify[] = ['success', 'Service marked as completed successfully'];
        return back()->withNotify($notify);
    }

    public function softwarePurchase()
    {
        $pageTitle   = 'Software Purchase Log';
        $softwareLog = Booking::where('software_id', '!=', 0)->where('buyer_id', auth()->id())->where('status' , '!=', Status::BOOKING_UNPAID)->with('seller')->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.software_log', compact('pageTitle', 'softwareLog'));
    }
}
