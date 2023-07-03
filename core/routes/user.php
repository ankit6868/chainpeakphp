<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function(){
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function(){
        Route::get('register/{reference?}', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function(){
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function(){
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function(){
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user-data', 'User\UserController@userData')->name('data');
        Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->group(function () {
            Route::namespace('User')->group(function () {
                Route::controller('UserController')->group(function(){
                    Route::get('dashboard', 'home')->name('home');

                    // Work File Upload
                    Route::post('work/file/upload/{orderNumberOrJobId}', 'workFileUpload')->name('work.upload');

                    // Dispute
                    Route::post('dispute/{orderNumberOrBidId}', 'dispute')->name('dispute');

                    // Extra Image Remove
                    Route::post('image-remove/{id}/{imageName}/{type}', 'removeExtraImage')->name('image.remove');

                    //2FA
                    Route::get('twofactor', 'show2faForm')->name('twofactor');
                    Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                    Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                    //KYC
                    Route::get('kyc-form','kycForm')->name('kyc.form');
                    Route::get('kyc-data','kycData')->name('kyc.data');
                    Route::post('kyc-submit','kycSubmit')->name('kyc.submit');

                    //Report
                    Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                    Route::get('transactions','transactions')->name('transactions');

                    Route::get('attachment-download/{fil_hash}','attachmentDownload')->name('attachment.download');
                });

                //Profile setting
                Route::controller('ProfileController')->group(function(){
                    Route::get('profile-setting', 'profile')->name('profile.setting');
                    Route::post('profile-setting', 'submitProfile');
                    Route::get('change-password', 'changePassword')->name('change.password');
                    Route::post('change-password', 'submitPassword');
                });

                // Withdraw
                Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function(){
                    Route::middleware('kyc')->group(function(){
                        Route::get('/', 'withdrawMoney');
                        Route::post('/', 'withdrawStore')->name('.money');
                        Route::get('preview', 'withdrawPreview')->name('.preview');
                        Route::post('preview', 'withdrawSubmit')->name('.submit');
                    });
                    Route::get('history', 'withdrawLog')->name('.history');
                });

                Route::controller('ServiceBookingController')->name('service.')->prefix('service')->group(function(){
                    Route::get('booking/{slug}/{id}','bookingForm')->name('booking.form');
                    Route::post('booking/booking/{id}','addBooking')->name('add.booking');
                    Route::get('booking/confirm','confirmBooking')->name('confirm.booking');
                    Route::get('coupon/apply','couponApply')->name('coupon.apply');
                    Route::get('coupon/remove','couponRemove')->name('coupon.remove');
                    Route::post('booking/payment','payment')->name('payment.booking');
                });

                Route::controller('SoftwareBookingController')->name('software.')->prefix('software')->group(function(){
                    Route::get('booking/confirm/{slug}/{id}','confirmBooking')->name('confirm.booking');
                    Route::get('coupon/apply','couponApply')->name('coupon.apply');
                    Route::get('coupon/remove','couponRemove')->name('coupon.remove');
                    Route::post('booking/payment','payment')->name('payment.booking');
                    Route::get('booking/payment','paymentPreview')->name('payment.booking');
                });

                // Job Bid Store
                Route::post('job/bidding', 'JobBiddingController@store')->name('job.bidding.store');

                // Chat Operations
                Route::post('chat', 'ChatController@store')->name('chat.store');

                // Inbox Operation
                Route::controller('InboxController')->prefix('inbox')->name('inbox.')->group(function(){
                    Route::get('list','list')->name('list');
                    Route::get('messages/{uniqueId}','messages')->name('messages');
                    Route::post('create','create')->name('create');
                    Route::post('message/store','store')->name('message.store');
                });

                // Product Comment Operation
                Route::controller('CommentController')->prefix('comment')->name('comment.')->group(function(){
                    Route::post('store','commentStore')->name('store');
                    Route::post('reply/store','replyStore')->name('reply.store');
                });

                // Reviews
                Route::post('review/store', 'ReviewController@store')->name('review.store');
            });

            Route::namespace('Seller')->name('seller.')->prefix('seller')->group(function () {
                Route::controller('SellerController')->group(function(){
                    Route::get('dashboard', 'home')->name('home');
                    Route::get('job/list', 'jobList')->name('job.list');
                    Route::get('job/details/{id}', 'jobDetails')->name('job.details');
                });

                Route::controller('ServiceController')->name('service.')->prefix('service')->group(function(){
                    Route::get('index', 'index')->name('index');
                    Route::get('new', 'new')->name('new');
                    Route::get('edit/{slug}/{id}', 'edit')->name('edit');
                    Route::post('store/{id?}', 'store')->name('store');
                    Route::post('extra-service/status/{serviceId}/{extraServiceId}', 'extraServiceStatus')->name('extra.service.status');
                    Route::post('extra-service/update/{serviceId}/{extraServiceId}', 'extraServiceUpdate')->name('extra.service.update');
                });

                Route::controller('ServiceController')->name('booking.service.')->prefix('service/booking')->group(function(){
                    Route::get('list', 'bookingList')->name('list');
                    Route::post('confirm/{orderNumber}', 'bookingConfirm')->name('confirm');
                    Route::post('cancel/{orderNumber}', 'bookingCancel')->name('cancel');
                    Route::get('details/{orderNumber}', 'bookingDetails')->name('details');
                });

                // Booked Service For Seller
                Route::controller('SoftwareController')->name('software.')->prefix('software')->group(function(){
                    Route::get('index', 'index')->name('index');
                    Route::get('new', 'new')->name('new');
                    Route::get('edit/{slug}/{id}', 'edit')->name('edit');
                    Route::post('store/{id?}', 'store')->name('store');
                });

                // Softwares Sales Log
                Route::get('software/sale/logs', 'SoftwareController@salesLog')->name('sale.software.log');
            });

            Route::namespace('Buyer')->name('buyer.')->prefix('buyer')->group(function () {
                Route::controller('BuyerController')->group(function(){
                    Route::get('dashboard', 'home')->name('home');

                    Route::name('booked.')->prefix('booked/services')->group(function () {
                        Route::get('/', 'bookedService')->name('services');
                        Route::get('details/{orderNumber}', 'bookedServiceDetails')->name('details');
                        Route::post('make/completed/{orderNumber}', 'serviceCompleted')->name('completed');
                    });

                    Route::get('software/purchase/log', 'softwarePurchase')->name('software.log');
                });

                Route::controller('JobController')->name('job.')->prefix('job')->group(function(){
                    Route::get('index', 'index')->name('index');
                    Route::get('new', 'new')->name('new');
                    Route::get('edit/{slug}/{id}', 'edit')->name('edit');
                    Route::post('store/{id?}', 'store')->name('store');
                    Route::post('close/{id}', 'close')->name('close');

                    // Job Bidding List
                    Route::get('bidding/list/{slug}/{id}', 'biddingList')->name('bidding.list');
                    Route::post('approve/{id}', 'bidApprove')->name('bid.approve');
                    Route::post('cancel/{id}', 'bidCancel')->name('bid.cancel');
                });

                Route::controller('JobController')->name('hiring.')->prefix('hiring')->group(function(){
                    Route::get('list', 'hiringList')->name('list');
                    Route::get('details/{id}', 'hiringDetails')->name('details');
                    Route::post('make/completed/{id}', 'hiringCompleted')->name('completed');
                });

                // Favorite Products
                Route::controller('FavoriteController')->prefix('favorite')->name('favorite.')->group(function(){
                    Route::post('store', 'store')->name('store');
                    Route::get('service', 'service')->name('service');
                    Route::get('software', 'software')->name('software');
                });
            });
        });

        // Payment
        Route::middleware('registration.complete')->prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function(){
            Route::any('/', 'deposit')->name('index');
            Route::post('insert/{orderNumber?}', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});
