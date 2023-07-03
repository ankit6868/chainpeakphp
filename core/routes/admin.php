


<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    // Admin Password Reset
    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('reset');
        Route::post('reset', 'sendResetCodeEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard')->middleware('permission:Manage Dashboard,admin');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

        // Chat Store
        Route::post('chat/store', 'chatStore')->name('chat.store');
    });

    // Category Manager
    Route::controller('CategoryController')->name('category.')->prefix('category')->middleware("permission:Manage Category")->group(function () {
        Route::get('/', 'categoryIndex')->name('index');
        Route::post('store/{id?}', 'categoryStore')->name('store');
        Route::post('status/{id?}', 'changeStatus')->name('status');
    });

    Route::controller('SubCategoryController')->name('subcategory.')->middleware("permission:Manage Subcategory")->prefix('subcategories')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('status/{id?}', 'changeStatus')->name('status');
    });

    // Feature Manager
    Route::controller('FeatureController')->middleware('permission:Manage Feature,admin')->name('feature.')->prefix('feature')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('status/{id?}', 'changeStatus')->name('status');
    });

    //Manage Advertisement
    Route::controller('AdvertisementController')->middleware("permission:Manage Advertisement")->name('advertisement.')->prefix('advertisement')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('remove/{id}', 'remove')->name('remove');
    });

    //Manage Level
    Route::controller('LevelController')->name('level.')->prefix('level')->middleware("permission:Manage Level")->group(function () {
        Route::get('/', 'levelIndex')->name('index');
        Route::post('store/{id?}', 'levelStore')->name('store');
        Route::post('status/{id?}', 'changeStatus')->name('status');
    });

    //Manage Coupon
    Route::controller('CouponController')->name('coupon.')->prefix('coupon')->middleware("permission:Manage Coupon")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('status/{id?}', 'changeStatus')->name('status');
    });

    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('users')->middleware("permission:Manage Users")->group(function () {
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('kyc-unverified', 'kycUnverifiedUsers')->name('kyc.unverified');
        Route::get('kyc-pending', 'kycPendingUsers')->name('kyc.pending');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('with-balance', 'usersWithBalance')->name('with.balance');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('kyc-data/{id}', 'kycDetails')->name('kyc.details');
        Route::post('kyc-approve/{id}', 'kycApprove')->name('kyc.approve');
        Route::post('kyc-reject/{id}', 'kycReject')->name('kyc.reject');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
    });

    // Subscriber
    Route::controller('SubscriberController')->middleware("permission:Manage Subscriber")->prefix('subscriber')->name('subscriber.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('send-email', 'sendEmailForm')->name('send.email');
        Route::post('remove/{id}', 'remove')->name('remove');
        Route::post('send-email', 'sendEmail')->name('send.email');
    });

    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->middleware('permission:Manage Gateway,admin')->group(function () {

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->prefix('automatic')->name('automatic.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{code}', 'update')->name('update');
            Route::post('remove/{id}', 'remove')->name('remove');
            Route::post('status/{id}', 'status')->name('status');
        });

        // Manual Methods
        Route::controller('ManualGatewayController')->prefix('manual')->name('manual.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('new', 'create')->name('create');
            Route::post('new', 'store')->name('store');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // DEPOSIT SYSTEM
    Route::controller('DepositController')->middleware("permission:Manage Deposit")->prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });

    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->middleware('permission:Manage Withdraw,admin')->group(function () {

        Route::controller('WithdrawalController')->group(function () {
            Route::get('pending', 'pending')->name('pending');
            Route::get('approved', 'approved')->name('approved');
            Route::get('rejected', 'rejected')->name('rejected');
            Route::get('log', 'log')->name('log');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });

        // Withdraw Method
        Route::controller('WithdrawMethodController')->prefix('method')->name('method.')->group(function () {
            Route::get('/', 'methods')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // Report
    Route::controller('ReportController')->prefix('report')->name('report.')->middleware("permission:Manage Report")->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('login/history', 'loginHistory')->name('login.history');
        Route::get('login/ipHistory/{ip}', 'loginIpHistory')->name('login.ipHistory');
        Route::get('notification/history', 'notificationHistory')->name('notification.history');
        Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
    });

    // Admin Support
    Route::controller('SupportTicketController')->prefix('ticket')->middleware("permission:Manage Support Ticket")->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pendingTicket')->name('pending');
        Route::get('closed', 'closedTicket')->name('closed');
        Route::get('answered', 'answeredTicket')->name('answered');
        Route::get('view/{id}', 'ticketReply')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{ticket}', 'ticketDownload')->name('download');
        Route::post('delete/{id}', 'ticketDelete')->name('delete');
    });

    // Manage Services
    Route::controller('ManageServiceController')->prefix('service')->name('service.')->middleware("permission:Manage Service")->group(function () {
        Route::get('pending', 'pending')->name('pending');
        Route::get('approved', 'approved')->name('approved');
        Route::get('canceled', 'canceled')->name('canceled');
        Route::get('closed', 'closed')->name('closed');
        Route::get('all', 'all')->name('all');
        Route::post('status/change/{id}/{type}', 'statusChange')->name('status.change');
        Route::post('featured/status/change/{id}/{type}', 'featuredStatusChange')->name('featured.status.change');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('win/seller/{id}', 'winSeller')->name('win.seller');
        Route::post('win/buyer/{id}', 'winBuyer')->name('win.buyer');
    });

    Route::controller('ManageServiceController')->prefix('service/booking')->name('booking.service.')->middleware("permission:Manage Service Booking")->group(function () {
        Route::get('pending', 'bookingPending')->name('pending');
        Route::get('completed', 'bookingCompleted')->name('completed');
        Route::get('delivered', 'bookingDelivered')->name('delivered');
        Route::get('inprogress', 'bookingInprogress')->name('inprogress');
        Route::get('disputed', 'bookingDisputed')->name('disputed');
        Route::get('refunded', 'bookingRefunded')->name('refunded');
        Route::get('expired', 'bookingExpired')->name('expired');
        Route::get('details/{id}', 'bookingDetails')->name('details');
    });

    // Manage Jobs
    Route::controller('ManageJobController')->prefix('job')->name('job.')->middleware("permission:Manage Job")->group(function () {
        Route::get('pending', 'pending')->name('pending');
        Route::get('approved', 'approved')->name('approved');
        Route::get('canceled', 'canceled')->name('canceled');
        Route::get('closed', 'closed')->name('closed');
        Route::get('all', 'all')->name('all');
        Route::post('status/change/{id}/{type}', 'statusChange')->name('status.change');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('bidding/list/{id}', 'biddingList')->name('bidding.list');
        Route::post('win/bidder/{id}', 'winBidder')->name('win.bidder');
        Route::post('win/buyer/{id}', 'winBuyer')->name('win.buyer');
    });


    Route::controller('ManageJobController')->prefix('job/hiring')->name('hiring.job.')->middleware("permission:Manage Job Bidding")->group(function () {
        Route::get('pending', 'hiringPending')->name('pending');
        Route::get('completed', 'hiringCompleted')->name('completed');
        Route::get('delivered', 'hiringDelivered')->name('delivered');
        Route::get('inprogress', 'hiringInprogress')->name('inprogress');
        Route::get('disputed', 'hiringDisputed')->name('disputed');
        Route::get('canceled', 'hiringCanceled')->name('canceled');
        Route::get('expired', 'hiringExpired')->name('expired');
        Route::get('details/{id}', 'hiringDetails')->name('details');
    });

    // Manage Softwares
    Route::controller('ManageSoftwareController')->prefix('software')->name('software.')->middleware("permission:Manage Software")->group(function () {
        Route::get('pending', 'pending')->name('pending');
        Route::get('approved', 'approved')->name('approved');
        Route::get('canceled', 'canceled')->name('canceled');
        Route::get('closed', 'closed')->name('closed');
        Route::get('all', 'all')->name('all');
        Route::post('status/change/{id}/{type}', 'statusChange')->name('status.change');
        Route::get('details/{id}', 'details')->name('details');
    });

    // Software Sales Log
    Route::get('software/sales/log', 'ManageSoftwareController@salesLog')->name('sales.software.log')->middleware("permission:Manage Software Sales");

    // Pending Payments
    Route::controller('SalesPaymentController')->middleware("permission:Manage Payment")->prefix('payment/pending')->name('payment.pending.')->group(function () {
        Route::get('service', 'service')->name('service');
        Route::get('software', 'software')->name('software');
    });

    // Language Manager
    Route::controller('LanguageController')->prefix('language')->middleware("permission:Manage Language")->name('language.')->group(function () {
        Route::get('/', 'langManage')->name('manage');
        Route::post('/', 'langStore')->name('manage.store');
        Route::post('delete/{id}', 'langDelete')->name('manage.delete');
        Route::post('update/{id}', 'langUpdate')->name('manage.update');
        Route::get('edit/{id}', 'langEdit')->name('key');
        Route::post('import', 'langImport')->name('import.lang');
        Route::post('store/key/{id}', 'storeLanguageJson')->name('store.key');
        Route::post('delete/key/{id}', 'deleteLanguageJson')->name('delete.key');
        Route::post('update/key/{id}', 'updateLanguageJson')->name('update.key');
    });

    Route::controller('GeneralSettingController')->group(function () {

        // General Setting
        Route::middleware("permission:Manage General Setting")->group(function () {
            Route::get('general-setting', 'index')->name('setting.index');
            Route::post('general-setting', 'update')->name('setting.update');
        });

        //configuration
        Route::middleware("permission:Manage System Configuration")->group(function () {
            Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
            Route::post('setting/system-configuration', 'systemConfigurationSubmit');
        });

        // Logo-Icon
        Route::middleware("permission:Manage Logo And Favicon")->group(function () {
            Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
            Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');
        });

        //Custom CSS
        Route::middleware("permission:Others")->group(function () {
            Route::get('custom-css', 'customCss')->name('setting.custom.css');
            Route::post('custom-css', 'customCssSubmit');
        });

        //Cookie
        Route::middleware("permission:Manage GDPR Cookie")->group(function () {
            Route::get('cookie', 'cookie')->name('setting.cookie');
            Route::post('cookie', 'cookieSubmit');
        });

        //maintenance_mode
        Route::middleware("permission:Manage Maintenance Mode")->group(function () {
            Route::get('maintenance-mode', 'maintenanceMode')->name('maintenance.mode');
            Route::post('maintenance-mode', 'maintenanceModeSubmit');
        });
    });

    //KYC setting
    Route::controller('KycController')->middleware("permission:Manage KYC Setting")->group(function () {
        Route::get('kyc-setting', 'setting')->name('kyc.setting');
        Route::post('kyc-setting', 'settingUpdate');
    });
    //staff route
    Route::controller('StaffController')->middleware("permission:Manage Staff")->name('staff.')->prefix('staff')->group(function () {
        Route::get('list', 'list')->name('index');
        Route::post('save/{id?}', 'save')->name('save');
        Route::post('remove/{id}', 'remove')->name('remove');
    });

    //Notification Setting
    Route::name('setting.notification.')->middleware("permission:Manage Notification Setting")->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global', 'global')->name('global');
        Route::post('global/update', 'globalUpdate')->name('global.update');
        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');
    });

    // Plugin
    Route::controller('ExtensionController')->prefix('extensions')->middleware("permission:Manage Extension")->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->middleware("permission:Others")->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
    });

    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo')->middleware("permission:Manage SEO Manager");

    // Frontend
    Route::name('frontend.')->controller("FrontendController")->prefix('frontend')->middleware("permission:Manage Frontend Section")->group(function () {
        Route::get('templates', 'templates')->name('templates');
        Route::post('templates', 'templatesActive')->name('templates.active');
        Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
        Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
        Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
        Route::post('remove/{id}', 'remove')->name('remove');
    });
});
