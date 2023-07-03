<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\GatewayCurrency;
use App\Models\Software;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoftwareBookingController extends Controller
{
    use BookingOrder;

    public function confirmBooking($slug, $id)
    {
        $pageTitle       = 'Software Booking';
        $software        = Software::where('id', $id)->active()->notAuthUser()->checkData()->with('user')->firstOrFail();
        $coupon          = Coupon::active()->count();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
                                $gate->where('status', Status::ENABLE);
                            })->with('method')->orderby('method_code')->get();

        session()->put('orderDetails', [
            'software'    => $software,
            'discount'    => 0.00,
            'totalPrice'  => $software->price,
            'grandTotal'  => $software->price,
            'orderNumber' => getTrx()
        ]);

        $orderDetails = session('orderDetails');
        $orderDetails = $this->clearCouponDiscount($orderDetails);

        if (count($orderDetails) < 5 && count($orderDetails) > 5) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        return view($this->activeTemplate . 'software.software_confirm', compact('pageTitle', 'software', 'orderDetails', 'coupon', 'gatewayCurrency'));
    }

    public function couponApply(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'coupon_code' => 'required|max:40',
            'software_id' => 'required|integer|gt:0',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $software = Software::where('id', $request->software_id)->active()->notAuthUser()->checkData()->firstOrFail();

        if (!$software) {
            return response()->json(['error' => 'Software not found or disabled']);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->active()->first();

        if (!$coupon) {
            return response()->json(['error' => 'Coupon not found or disabled']);
        }

        if (session('couponDiscount')) {
            return response()->json(['error' => 'A coupon has already been applied']);
        }

        $grandTotal = $this->discountCalculation($software->price, $coupon);

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
}
