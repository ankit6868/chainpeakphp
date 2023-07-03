<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    public function service()
    {
        $general = gs();
        $general->service_cron = now();
        $general->save();

        $bookings = Booking::incomplete()
                    ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
                    ->leftJoin('users', 'users.id', '=', 'bookings.buyer_id')
                    ->select('users.id as user_id', 'users.balance as user_balance', 'bookings.final_price', 'bookings.order_number')
                    ->selectRaw('DATE_ADD(bookings.created_at, INTERVAL (services.delivery_time) day) as expired_date')
                    ->having('expired_date', '>', now())
                    ->get();

        $now       = '"' . now()->format('Y-m-d H:i:s') . '"';
        $statement = "update `bookings` left join `services` on `services`.`id` = `bookings`.`service_id` left join `users` on `users`.`id` = `bookings`.`buyer_id` set `users`.`balance` = users.balance + bookings.final_price, `users`.`updated_at` = $now, `bookings`.`updated_at` = $now, `bookings`.`status` = 6, `bookings`.`working_status` = 4 where `bookings`.`service_id` != 0 and `bookings`.`status` in (0, 3, 5)";

        DB::statement($statement);

        $transactions= [];

        foreach ($bookings as $booking) {

            $transaction['user_id']      = $booking->user_id;
            $transaction['amount']       = $booking->final_price;
            $transaction['post_balance'] = $booking->user_balance + $booking->final_price;
            $transaction['trx_type']     = '+';
            $transaction['details']      = 'Booking amount refunded';
            $transaction['trx']          = $booking->order_number;
            $transaction['remark']       = 'service_expired';
            $transaction['created_at']   = now();

            $transactions[]               = $transaction;
        }

        Transaction::insert($transactions);

        return "SERVICE CRON EXECUTED";
    }

    public function job()
    {
        $general           = gs();
        $general->job_cron = now();
        $general->save();

        $now = '"' . now()->format('Y-m-d H:i:s') . '"';

        $statement = "update `job_bids` left join `jobs` on `jobs`.`id` = `job_bids`.`job_id` set `job_bids`.`updated_at` = $now, `job_bids`.`status` = 6, `job_bids`.`working_status` = 4 where `job_bids`.`status` = 0";

        DB::statement($statement);

        return "JOB CRON EXECUTED";
    }
}
