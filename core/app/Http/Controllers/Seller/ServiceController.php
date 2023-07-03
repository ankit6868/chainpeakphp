<?php

namespace App\Http\Controllers\Seller;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ExtraService;
use App\Models\Feature;
use App\Models\Service;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\WorkFile;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Services';
        $services  = Service::where('user_id', auth()->id())->latest()->with('category')->searchAble(['name'])->paginate(getPaginate());
        return view($this->activeTemplate . 'seller.service.index', compact('pageTitle', 'services'));
    }

    public function new()
    {
        $pageTitle  = 'New Service';
        $features   = Feature::active()->latest()->get();
        $categories = Category::active()->orderBy('name')->with('subCategories', function ($q) {
            $q->active();
        })->get();
        return view($this->activeTemplate . 'seller.service.new', compact('pageTitle', 'features', 'categories'));
    }

    public function edit($slug, $id)
    {
        $pageTitle  = 'Edit Service';
        $service    = Service::where('id', $id)->where('user_id', auth()->id())->with('extraServices')->firstOrFail();

        if($service->status == Status::CANCELED){
            $notify[] = ["You can't edit canceled service"];
            return back()->withNotify($notify);
        }

        $features   = Feature::active()->latest()->get();
        $categories = Category::orderBy('name')->with('subCategories', function ($q) {
            $q->active();
        })->get();
        return view($this->activeTemplate . 'seller.service.edit', compact('pageTitle', 'features', 'categories', 'service'));
    }

    public function store(Request $request, $id = 0)
    {

        $this->serviceValidation($request, $id);
        $check = $this->checkData($request, $id);

        if ($check[0] == 'error') {
            $notify[] = $check;
            return back()->withNotify($notify);
        }

        if ($id) {
            $service      = Service::where('id', $id)->where('user_id', auth()->id())->where('status','!=',Status::CANCELED)->firstOrFail();
            $notification = 'Service updated successfully';
        } else {
            $service          = new Service();
            $service->user_id = auth()->id();
            $notification     = 'Service added successfully';
        }

        if ($request->hasFile('image')) {
            $serviceImage   = fileUploader($request->image, getFilePath('service'), getFileSize('service'), @$service->image);
            $service->image = $serviceImage;
        }

        $extraImage = $id ? $service->extra_image : [];

        if ($request->hasFile('extra_image')) {
            foreach ($request->extra_image as $singleImage) {
                $extraImage[] = fileUploader($singleImage, getFilePath('extraImage'), getFileSize('extraImage'));
            }
        }
        if (gs()->post_approval) {
            $service->status =  Status::APPROVED;
        }else{
            $service->status =  Status::PENDING;
        }


        $service->tag             = $request->tag;
        $service->name            = $request->name;
        $service->price           = $request->price;
        $service->features        = $request->features;
        $service->description     = $request->description;
        $service->extra_image     = $extraImage;
        $service->category_id     = $request->category_id;
        $service->max_order_qty   = $request->max_order_qty;
        $service->delivery_time   = $request->delivery_time;
        $service->sub_category_id = $request->sub_category_id;
        $service->save();

        $extraService = [];

        if ($request->extra_name) {
            foreach ($request->extra_name as $key => $extraName) {
                $data['name']       = $extraName;
                $data['price']      = $request->extra_price[$key];
                $data['service_id'] = $service->id;
                $data['created_at'] = now();
                $data['updated_at'] = now();
                $extraService[]     = $data;
            }
        }

        if (!empty($extraService)) {
            ExtraService::insert($extraService);
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function extraServiceUpdate(Request $request, $serviceId, $extraServiceId)
    {
        $request->validate([
            'extra_name'  => 'required|string|max:255',
            'extra_price' => 'required|numeric|gt:0',
        ]);

        $service      = Service::where('id', $serviceId)->where('user_id', auth()->id())->firstOrFail();
        $extraService = ExtraService::where('id', $extraServiceId)->where('service_id', $service->id)->firstOrFail();

        $extraService->name  = $request->extra_name;
        $extraService->price = $request->extra_price;
        $extraService->save();

        $notify[] = ['success', 'Service updated successfully'];
        return back()->withNotify($notify);
    }

    public function extraServiceStatus($serviceId, $extraServiceId)
    {
        $service      = Service::where('id', $serviceId)->where('user_id', auth()->id())->firstOrFail();
        $extraService = ExtraService::where('id', $extraServiceId)->where('service_id', $service->id)->firstOrFail();

        return ExtraService::changeStatus($extraService->id);
    }

    public function bookingList()
    {
        $pageTitle      = 'Service Booking List';
        $bookedServices = Booking::where('service_id', '!=', 0)->where('seller_id', auth()->id())->where('status', '!=', Status::BOOKING_UNPAID)->with(['service', 'buyer'])->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.service.booking_list', compact('pageTitle', 'bookedServices'));
    }

    public function bookingDetails($orderNumber)
    {
        $pageTitle      = 'Service Booking Details';
        $details        = Booking::checkServiceBookingData($orderNumber)->where('seller_id', auth()->id())->with('disputer')->firstOrFail();
        $extraServices  = ExtraService::where('service_id', $details->service_id)->find(json_decode($details->extra_services));
        $workFiles      = WorkFile::where('booking_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());
        $chats          = Chat::where('booking_id', $details->id)->with('user')->get();

        return view($this->activeTemplate . 'user.service.booking_details', compact('pageTitle', 'details', 'extraServices', 'workFiles', 'chats'));
    }

    public function bookingConfirm($orderNumber)
    {
        $booking = Booking::checkServiceBookingData($orderNumber)->where('seller_id', auth()->id())->where('status', Status::BOOKING_PENDING)->firstOrFail();

        $booking->status         = Status::BOOKING_APPROVED;
        $booking->working_status = Status::WORKING_INPROGRESS;
        $booking->updated_at     = now();
        $booking->save();

        notify($booking->buyer, 'SERVICE_BOOKING_CONFIRMED', [
            'seller_username' => $booking->seller->username,
            'order_number'    => $booking->order_number,
            'service_name'    => $booking->service->name,
            'price'           => showAmount($booking->final_price) . ' ' . gs()->cur_text,
            'delivery_time'   => showDateTime($booking->created_at->addDays($booking->service->delivery_time), ('M, d - Y'))
        ]);

        $notify[] = ['success', 'Booking confirmed successfully'];
        return back()->withNotify($notify);
    }

    public function bookingCancel($orderNumber)
    {
        $booking = Booking::checkServiceBookingData($orderNumber)->where('seller_id', auth()->id())->where('status', Status::BOOKING_PENDING)->with(['buyer', 'service'])->firstOrFail();

        $booking->status         = Status::BOOKING_REFUNDED;
        $booking->working_status = null;
        $booking->updated_at     = now();
        $booking->save();

        $booking->buyer->balance += $booking->final_price;
        $booking->buyer->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->buyer->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->buyer->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added as refund for a service named ' . $booking->service->name . ' by System';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'booking_refunded';
        $transaction->save();

        notify($booking->buyer, 'SERVICE_BOOKING_CANCELED', [
            'seller_username' => $booking->seller->username,
            'order_number'    => $booking->order_number,
            'service_name'    => $booking->service->name,
            'refund_amount'   => showAmount($booking->final_price) . ' ' . gs()->cur_text,
            'post_balance'    => showAmount($booking->buyer->balance) . ' ' . gs()->cur_text,
        ]);

        $notify[] = ['success', 'Booking canceled and refunded to buyer successfully'];
        return back()->withNotify($notify);
    }

    protected function serviceValidation($request, $id)
    {
        $imageValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'image'           => [$imageValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'extra_image.*'   => ['nullable', 'image', 'max:2048', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'features.*'      => 'nullable|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'max_order_qty'   => 'required|integer|min:1',
            'delivery_time'   => 'required|integer|min:1',
            'tag'             => 'required|array|min:3|max:15',
            'description'     => 'required',
            'extra_name.*'    => 'required_with:extra_price|string|max:255',
            'extra_price.*'   => 'required_with:extra_name|numeric|gt:0',
        ]);
    }

    protected function checkData($request, $id)
    {
        $category    = Category::active();
        $subcategory = SubCategory::active();
        $features    = Feature::active();

        $category = $category->where('id', $request->category_id)->first();

        if (!$category) {
            return ['error', 'Category not found or disabled'];
        } else {
            $subcategory = $subcategory->where('id', $request->sub_category_id)->where('category_id', $category->id)->first();
            if (!$subcategory) {
                return ['error', 'Subcategory not found or disabled'];
            }
        }

        if ($request->features) {
            $features = $features->findOrFail($request->features);

            if (!$features) {
                return ['error', 'Features not found or disabled'];
            }
        }

        if ($request->extra_name && $request->extra_price && (count($request->extra_name) != count($request->extra_price))) {
            return ['error', 'Invalid extra service'];
        }

        return ['success'];
    }
}
