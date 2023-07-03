<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feature;
use App\Models\Software;
use Illuminate\Http\Request;

class ManageSoftwareController extends Controller
{
    public $pageTitle;

    protected function softwareData($scope = null)
    {
        if ($scope) {
            $softwares = Software::$scope();
        } else {
            $softwares = Software::query();
        }

        $softwares = $softwares->searchable(['name', 'user:username', 'category:name', 'subCategory:name'])->filter(['user_id'])->latest()->with(['user', 'category', 'subCategory'])->paginate(getPaginate());
        $pageTitle = $this->pageTitle . ' Softwares';

        return view('admin.software.index', compact('pageTitle', 'softwares'));
    }

    public function all()
    {
        $this->pageTitle = 'All';
        return $this->softwareData(null);
    }
    public function pending()
    {
        $this->pageTitle = 'Pending';
        return $this->softwareData('pending');
    }

    public function approved()
    {
        $this->pageTitle = 'Approved';
        return $this->softwareData('approved');
    }

    public function canceled()
    {
        $this->pageTitle = 'Canceled';

        return $this->softwareData('canceled');
    }

    public function closed()
    {
        $this->pageTitle = 'Closed';
        return $this->softwareData('closed');
    }

    public function statusChange($id, $type)
    {
        $software = Software::where('id', $id)->where('status', Status::PENDING)->firstOrFail();

        if ($type == 'approve') {
            $notification     = 'approved';
            $software->status = Status::APPROVED;
        } else {
            $notification     = 'canceled';
            $software->status = Status::CANCELED;
        }

        $software->updated_at = now();
        $software->save();

        $notify[] = ['success', "Software $notification successfully"];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $pageTitle = 'Software Details';
        $software  = Software::with('user')->findOrFail($id);
        $features  = Feature::find($software->features);
        return view('admin.software.details', compact('pageTitle', 'software', 'features'));
    }

    public function salesLog()
    {
        $pageTitle = 'Software Sales Log';
        $salesLog  = Booking::where('software_id', '!=', 0)->where('status', '!=', Status::BOOKING_UNPAID)->with(['buyer', 'seller', 'software'])->latest()->paginate(getPaginate());
        return view('admin.software.sales_log', compact('pageTitle', 'salesLog'));
    }
}
