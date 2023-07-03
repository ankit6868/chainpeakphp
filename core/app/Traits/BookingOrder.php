<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Booking;
use App\Models\GatewayCurrency;
use App\Models\Transaction;

trait BookingOrder
{
    protected static function bookingCreate($orderDetails)
    {

        $booking               = new Booking();
        $booking->order_number = $orderDetails['orderNumber'];
        $booking->buyer_id     = auth()->id();
        $booking->price        = $orderDetails['totalPrice'];
        $booking->discount     = $orderDetails['discount'];
        $booking->final_price  = $orderDetails['grandTotal'];

        if (count($orderDetails) == 9) {
            $booking->service_id    = $orderDetails['service']->id;
            $booking->quantity      = $orderDetails['quantity'];
            $booking->service_price = $orderDetails['price'];
            $booking->extra_price   = $orderDetails['extraServicePrice'];
            $booking->seller_id     = $orderDetails['service']->user->id;

            if ($orderDetails['extraServices']) {
                $booking->extra_services = $orderDetails['extraServices']->pluck('id');
            }
        } elseif (count($orderDetails) == 5) {
            $booking->software_id = $orderDetails['software']->id;
            $booking->quantity    = 1;
            $booking->seller_id   = $orderDetails['software']->user->id;
        } else {
            return false;
        }

        $booking->save();
        return $booking;
    }

    protected static function bookingTransactionCreate($booking, $user, $deposit = null)
    {
        $user->balance -= $booking->final_price;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = $deposit ? $deposit->charge : 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Subtracted for booking';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'payment';
        $transaction->save();

        if ($booking->software_id) {
            $booking->seller->balance += $booking->final_price;
            $booking->seller->earning += $booking->final_price;
            $booking->seller->save();

            userLevel($booking->seller);

            $transaction               = new Transaction();
            $transaction->user_id      = $booking->seller->id;
            $transaction->amount       = $booking->final_price;
            $transaction->post_balance = $booking->seller->balance;
            $transaction->charge       = $deposit ? $deposit->charge : 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Added for selling software';
            $transaction->trx          = $booking->order_number;
            $transaction->remark       = 'software_sold';
            $transaction->save();

            notify($booking->seller, 'SOFTWARE_SOLD', [
                'buyer_username' => $booking->buyer->username,
                'order_number'   => $booking->order_number,
                'software_name'  => $booking->software->name,
                'price'          => showAmount($booking->final_price) . ' ' . gs()->cur_text,
                'post_balance'   => showAmount($booking->seller->balance) . ' ' . gs()->cur_text,
            ]);
        }
    }

    protected static function bookingStatusChange($id)
    {
        $booking = Booking::where('id', $id)->first();

        if ($booking->service_id) {
            $booking->status = Status::BOOKING_PENDING;
        }

        if ($booking->software_id) {
            $booking->status = Status::BOOKING_PAID;

            $booking->software->total_sale += 1;
            $booking->software->save();
        }

        $booking->save();

        return $booking;
    }

    protected function clearCouponDiscount($orderDetails)
    {
        session()->forget('couponDiscount');
        session()->put('orderDetails.discount', 0.00);
        session()->put('orderDetails.grandTotal', session('orderDetails.totalPrice'));
        $orderDetails = session('orderDetails');
        return $orderDetails;
    }

    protected static function clearSessionData()
    {
        session()->forget('orderDetails');
        session()->forget('couponDiscount');
    }

    protected function discountCalculation($totalPrice, $coupon)
    {
        $discount = 0;

        if ($coupon->type == Status::FIXED) {
            $discount = $coupon->value;
        } else {
            $discount = ($totalPrice * $coupon->value) / 100;
        }
        $grandTotal = $totalPrice - $discount;

        if ($grandTotal < 0) {
            return ['negative'];
        }

        return [getAmount($grandTotal, 2), getAmount($discount, 2)];
    }

    public function paymentProcess($request)
    {
        $request->validate([
            'payment_method' => 'required|integer|min:0'
        ]);

        $orderDetails = session('orderDetails');

        if (!$orderDetails) {
            $notify[] = ['error', 'Order booking not found!'];
            return to_route('home')->withNotify($notify);
        }

        $user   = auth()->user();
        $amount = $orderDetails['grandTotal'];

        if ($request->payment_method == 0) {

            if ($amount > $user->balance) {
                $notify[] = ['error', 'You don\'t have enough balance!'];
                return back()->withNotify($notify);
            }

            $bookingCreate = static::bookingCreate($orderDetails);
            $booking       = static::bookingStatusChange($bookingCreate->id);

            static::bookingTransactionCreate($booking, $user);
            static::clearSessionData();

            return to_route('user.home');
        } else {


            $pageTitle = 'Payment Preview';
            $gateway   = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', Status::ENABLE);
            })->where('method_code', $request->payment_method)->first();


            if (!$gateway) {
                $notify[] = ['error', 'Invalid gateway'];
                return back()->withNotify($notify);
            }

            $charge  = $gateway->fixed_charge + ($orderDetails['grandTotal'] * $gateway->percent_charge / 100);
            $payable = $amount + $charge;

            return view($this->activeTemplate . 'user.checkout', compact('pageTitle', 'orderDetails', 'gateway', 'amount', 'charge', 'payable'));
        }
    }

}
