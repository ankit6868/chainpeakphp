<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Language;
use App\Models\Service;
use App\Models\Software;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $general                         = gs();
        $activeTemplate                  = activeTemplate();
        $viewShare['policyPages']        = getContent('policy_pages.element',false,null,true);
        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language']           = Language::all();
        $viewShare['emptyMessage']       = 'Data not found';
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'            => User::banned()->count(),
                'emailUnverifiedUsersCount'   => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'  => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'     => User::kycUnverified()->count(),
                'kycPendingUsersCount'        => User::kycPending()->count(),
                'pendingTicketCount'          => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount'        => Deposit::pending()->where('order_number', null)->count(),
                'pendingWithdrawCount'        => Withdrawal::pending()->count(),
                'pendingServiceCount'         => Service::pending()->count(),
                'pendingJobCount'             => Job::pending()->count(),
                'pendingSoftwareCount'        => Software::pending()->count(),
                'pendingServiceBookingCount'  => Booking::where('service_id', '!=', 0)->pending()->count(),
                'disputedServiceBookingCount' => Booking::where('service_id', '!=', 0)->disputed()->count(),
                'pendingJobBookingCount'      => JobBid::pending()->count(),
                'disputedJobBookingCount'     => JobBid::disputed()->count(),
                'paymentPendingServiceCount'  => Deposit::pending()->paymentPendingService()->count(),
                'paymentPendingSoftwareCount' => Deposit::pending()->paymentPendingSoftware()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });
        view()->composer([$activeTemplate."partials.filter",$activeTemplate."partials.footer",$activeTemplate."partials.header"], function ($view) {
            $view->with([
                'categories' =>Category::active()->orderBy('name')->get()
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFour();
    }
}
