<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class SalesPaymentController extends Controller
{
    public function service()
    {
        $pageTitle = 'Payment Pending Services';
        $deposits  = Deposit::pending()->paymentPendingService()->latest()->with('booking.service')->paginate(getPaginate());

        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function software()
    {
        $pageTitle = 'Payment Pending Softwares';
        $deposits  = Deposit::pending()->paymentPendingSoftware()->latest()->with('booking.software')->paginate(getPaginate());

        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }
}
