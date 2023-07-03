<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\ExtraService;
use App\Models\GatewayCurrency;
use App\Models\Service;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceBookingController extends Controller
{
    use BookingOrder;

    public function bookingForm($slug, $id)
    {
        $pageTitle      = 'Service Booking';
        $service        = Service::where('id', $id)->active()->notAuthUser()->checkData()->with('user')->firstOrFail();
        $extraServices  = ExtraService::where('service_id', $service->id)->active()->latest()->get();
        return view($this->activeTemplate . 'service.service_booking', compact('pageTitle', 'service', 'extraServices'));
    }

    public function addBooking(Request $request, $id)
    {
        $request->validate([
            'service_qty'      => 'required|integer|gt:0',
            'extra_services.*' => 'nullable|integer|gt:0',
        ]);

        $service           = Service::where('id', $id)->active()->notAuthUser()->checkData()->with('user')->firstOrFail();
        $extraServices     = null;
        $extraServicePrice = 0;

        if ($request->extra_services) {
            $extraServicesCheck = $this->extraServicePriceCalculation($request->extra_services, $service->id);

            if($extraServicesCheck[0] == 'notFoundOrDisabled') {
                $notify[] = ['error','Extra service not found or disabled'];
                return back()->withNotify($notify);
            }
            
            $extraServices     = $extraServicesCheck[0];
            $extraServicePrice = $extraServicesCheck[1];
        }

        $quantity     = $request->service_qty;
        $servicePrice = $service->price * $quantity;
        $totalPrice   = $servicePrice + $extraServicePrice;

        session()->forget('orderDetails');
        session()->put('orderDetails', [
            'service'           => $service,
            'discount'          => 0.00,
            'quantity'          => $quantity,
            'totalPrice'        => $totalPrice,
            'grandTotal'        => $totalPrice,
            'orderNumber'       => getTrx(),
            'price'             => $servicePrice,
            'extraServices'     => $extraServices,
            'extraServicePrice' => $extraServicePrice,
        ]);

        return to_route('user.service.confirm.booking');
    }

    public function confirmBooking()
    {
        $pageTitle    = 'Service Booking Confirmation';
        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        if (count($orderDetails) < 9) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        $orderDetails    = $this->clearCouponDiscount($orderDetails);
        $coupon          = Coupon::active()->count();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
                                $gate->where('status', Status::ENABLE);
                            })->with('method')->orderby('method_code')->get();

        return view($this->activeTemplate . 'service.service_confirm', compact('pageTitle', 'orderDetails', 'coupon', 'gatewayCurrency'));
    }

    public function couponApply(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'coupon_code'      => 'required|max:40',
            'service_id'       => 'required|integer|gt:0',
            'service_qty'      => 'required|integer|gt:0',
            'extra_services.*' => 'nullable|integer|gt:0',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $service = Service::where('id', $request->service_id)->active()->notAuthUser()->checkData()->first();

        if (!$service) {
            return response()->json(['error' => 'Service not found or disabled']);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->active()->first();

        if (!$coupon) {
            return response()->json(['error' => 'Coupon not found or disabled']);
        }

        if (session('couponDiscount')) {
            return response()->json(['error' => 'A coupon has already been applied']);
        }

        $extraServicePrice = 0;
        $extraServicesId   = json_decode($request->extra_services);

        if ($extraServicesId) {
            $extraServicesCheck = $this->extraServicePriceCalculation($extraServicesId, $service->id);

            if($extraServicesCheck[0] == 'notFoundOrDisabled') {
                $notify[] = ['error','Extra service not found or disabled'];
                return back()->withNotify($notify);
            }

            $extraServicePrice = $extraServicesCheck[1];
        }

        $totalPrice = ($service->price * $request->service_qty) + $extraServicePrice;
        $grandTotal = $this->discountCalculation($totalPrice, $coupon);

        if ($grandTotal[0] == 'negative') {
            return response()->json(['error' => 'Discount can\'t be grater grand total price']);
        }

        session()->put('couponDiscount', true);
        session()->put('orderDetails.discount', $grandTotal[1]);
        session()->put('orderDetails.grandTotal', $grandTotal[0]);

        return response()->json([
            'grandTotal' => $grandTotal[0],
            'discount'   => $grandTotal[1],
        ]);
    }

    public function couponRemove()
    {
        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            return response()->json(['error' => 'Order booking not found!']);
        }

        $couponCheck = session('couponDiscount');

        if (!$couponCheck) {
            return response()->json(['error' => 'Any coupon hasn\'t been applied yet!']);
        }

        $orderDetails = $this->clearCouponDiscount($orderDetails);

        return response()->json([
            'grandTotal' => $orderDetails['grandTotal'],
            'discount'   => $orderDetails['discount'],
        ]);
    }

    public function payment(Request $request)
    {
        return $this->paymentProcess($request);
    }

    protected function extraServicePriceCalculation($requestedExtraServices, $serviceId)
    {
        $extraServices = ExtraService::whereIn('id', $requestedExtraServices)->where('service_id', $serviceId)->active()->get();

        if($extraServices->count() != count($requestedExtraServices)) {
            return ['notFoundOrDisabled'];
        }

        return [$extraServices ,$extraServices->sum('price')];
    }
}
