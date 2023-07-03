<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Constants\Status;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\JobBid;
use App\Models\Service;
use App\Models\Software;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WorkFile;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function home()
    {
        $pageTitle    = 'Seller Dashboard';
        $authId       = auth()->id();

        $transactions = Transaction::where('user_id', $authId)->orderBy('id','desc')->limit(10)->get();

        $totalServiceCount     = Service::where('user_id', $authId)->count();
        $totalSoftwareCount    = Software::where('user_id', $authId)->count();

        $totalSoftwareSales    = Booking::where('software_id', '!=', 0)->where('seller_id', $authId)->where('status', '!=', Status::BOOKING_UNPAID)->count();
        $totalServiceBooking   = Booking::where('service_id', '!=', 0)->where('seller_id', $authId)->where('status', '!=', Status::BOOKING_UNPAID)->count();
        $totalWithdrawalAmount = Withdrawal::where('user_id', $authId)->where('status', '!=', Status::PAYMENT_INITIATE)->sum('amount');

        return view($this->activeTemplate . 'seller.dashboard', compact('pageTitle', 'transactions', 'totalServiceCount', 'totalSoftwareCount', 'totalServiceBooking', 'totalSoftwareSales', 'totalWithdrawalAmount'));
    }

    public function jobList()
    {
        $pageTitle   = 'Job List';
        $biddingList = JobBid::where('user_id', auth()->id())->with(['job', 'buyer'])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.job.job_hiring' , compact('pageTitle', 'biddingList'));
    }

    public function jobDetails($id)
    {
        $pageTitle = 'Job Details';
        $details   = JobBid::where('id', $id)->where('user_id', auth()->id())->with(['job', 'disputer'])->firstOrFail();
        $workFiles = WorkFile::where('job_bid_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());
        $chats     = Chat::where('job_bid_id', $details->id)->with('user')->get();

        return view($this->activeTemplate . 'user.job.details', compact('pageTitle', 'details', 'workFiles', 'chats'));
    }
}
