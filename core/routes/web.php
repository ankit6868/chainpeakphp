<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

//Crons
Route::get('cron/service-expired', 'CronController@service')->name('cron.service.expired');
Route::get('cron/job-expired', 'CronController@job')->name('cron.job.expired');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});


Route::controller('SearchController')->group(function () {
    Route::get('search', 'search')->name('search');
    Route::get('filter', 'filter')->name('filter');
});

// Fetch More Operations
Route::controller('FetchController')->prefix('fetch')->name('fetch.')->group(function () {
    Route::get('reviews/{id}', 'fetchReviews')->name('reviews');
    Route::get('comments/{id}', 'fetchComments')->name('comments');
    Route::get('featured/services', 'fetchFeaturedServices')->name('featured.services');
    Route::get('products', '')->name('products');
});

Route::controller('SiteController')->group(function () {
    Route::get('adRedirect/{id}', 'adRedirect')->name('adRedirect');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');

    // Subscriber Store
    Route::post('subscriber', 'subscriberStore')->name('subscriber.store');

    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('blog', 'blogs')->name('blogs');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    // Services
    Route::get('service', 'service')->name('service');
    Route::get('service/details/{slug}/{id}', 'serviceDetails')->name('service.details');

    // Software
    Route::get('software', 'software')->name('software');
    Route::get('software/details/{slug}/{id}', 'softwareDetails')->name('software.details');

    // Job
    Route::get('job', 'job')->name('job');
    Route::get('job/details/{slug}/{id}', 'jobDetails')->name('job.details');

    // File Download
    Route::get('file-download/{fileName}/{type}', 'fileDownload')->name('file.download');

    // User Profile
    Route::get('user/{username}', 'publicProfile')->name('public.profile');

    // Products By Category-Subcategory
    Route::get('category/{slug}/{id}', 'productsByCategory')->name('by.category');
    Route::get('subcategory/{slug}/{id}', 'productsBySubcategory')->name('by.subcategory');

    // Homepage
    Route::get('/', 'index')->name('home');
});


