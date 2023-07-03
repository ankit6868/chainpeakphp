<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\Chat;
use App\Models\User;
use App\Models\JobBid;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Service;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Software;
use App\Models\WorkFile;
use App\Constants\Status;
use App\Models\Subscriber;
use App\Models\SubCategory;
use App\Models\ExtraService;
use App\Traits\BookingOrder;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    use BookingOrder;

    public function index()
    {

        static::clearSessionData();

        $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }

        session()->forget('orderDetails');
        $pageTitle  = 'Home';

        $products   = Service::active()->featured()->userActiveCheck()->checkData()->latest()->with(['user', 'user.level']);

        if (request()->sorting) {
            if (request()->sorting == 'high') {
                $products = $products->orderBy('price', "DESC");
            } elseif (request()->sorting == "low") {
                $products = $products->orderBy('price', "ASC");
            } else {
                $products = $products->orderBy('id', "DESC");
            }
        } else {
            $products = $products->orderBy('id', "DESC");
        }

        $products   = $products->paginate(getPaginate());
        $priceRange = $this->priceRangeCalc($products);
        $type       = 'service';
        return view($this->activeTemplate . 'home', compact('pageTitle', 'products', 'priceRange', 'type'));
    }

    public function productsByCategory($slug, $id)
    {
        $category  = Category::where('id', $id)->active()->with('subCategories', function ($subCategories) {
            $subCategories->active();
        })->firstOrFail();
        $pageTitle = $category->name;
        $services  = Service::where('category_id', $category->id)->active()->userActiveCheck()->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        })->latest()->limit(10)->with('user')->get();
        $softwares = Software::where('category_id', $category->id)->active()->userActiveCheck()->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        })->latest()->limit(10)->with('user')->get();
        $jobs      = Job::where('category_id', $category->id)->active()->userActiveCheck()->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        })->latest()->limit(10)->with('user')->get();

        return view($this->activeTemplate . 'products', compact('pageTitle', 'category', 'services', 'softwares', 'jobs'));
    }

    public function productsBySubcategory($slug, $id)
    {
        $subcategory = SubCategory::where('id', $id)->active()->whereHas('category', function ($category) {
            $category->active();
        })->firstOrFail();
        $pageTitle   = $subcategory->name;
        $services    = Service::where('sub_category_id', $subcategory->id)->active()->userActiveCheck()->latest()->limit(10)->with('user')->get();
        $softwares   = Software::where('sub_category_id', $subcategory->id)->active()->userActiveCheck()->latest()->limit(10)->with('user')->get();
        $jobs        = Job::where('sub_category_id', $subcategory->id)->active()->userActiveCheck()->latest()->limit(10)->with('user')->get();

        return view($this->activeTemplate . 'products', compact('pageTitle', 'subcategory', 'services', 'softwares', 'jobs'));
    }

    public function service()
    {
        $pageTitle = 'Service';
        $query     = Service::active()->userActiveCheck()->checkData()->latest()->with(['user', 'user.level']);
        if (request()->tag) {
            $query->whereJsonContains('tag', request()->tag);
        }
        $products   = $query->paginate(getPaginate());
        $priceRange = $this->priceRangeCalc($products);
        $type       = 'service';
        return view($this->activeTemplate . 'home', compact('pageTitle', 'products', 'priceRange', 'type'));
    }

    public function serviceDetails($slug, $id)
    {
        $pageTitle      = 'Service Details';
        $productDetails = Service::where('id', $id)->active()->userActiveCheck()->checkData()->with('user')->firstOrFail();
        //$productDetails   = Service::where('id', $id)->active()->with('user')->firstOrFail();
        $extraServices    = ExtraService::where('service_id', $productDetails->id)->active()->latest()->get();
        $comments         = Comment::where('service_id', $productDetails->id)->latest()->with(['user', 'replies', 'replies.user'])->limit(6)->get();
        $reviews          = Review::where('service_id', $productDetails->id)->latest()->with('user')->limit(6)->get();
        $seoContents      = $this->seoContentSliced($productDetails->tag, $productDetails->name, $productDetails->description, getFilePath('service'), $productDetails->image, getFileSize('service'));
        $reviewPermission = $this->reviewPermission('service', $productDetails->id);

        static::clearSessionData();

        return view($this->activeTemplate . 'service.service_details', compact('pageTitle', 'productDetails', 'comments', 'reviews', 'reviewPermission', 'extraServices', 'seoContents'));
    }

    public function software()
    {
        $pageTitle = 'Software';
        $query     = Software::active()->userActiveCheck()->checkData()->latest()->with(['user', 'user.level']);
        if(request()->tag){
            $query->whereJsonContains('tag',request()->tag);
        }
        $products   = $query->paginate(getPaginate());
        $priceRange = $this->priceRangeCalc($products);
        $type       = 'software';
        return view($this->activeTemplate . 'home', compact('pageTitle', 'products', 'priceRange', 'type'));
    }

    public function softwareDetails($slug, $id)
    {
        $pageTitle        = 'Software Details';
        $productDetails   = Software::where('id', $id)->active()->userActiveCheck()->checkData()->firstOrFail();
        $comments         = Comment::where('software_id', $productDetails->id)->latest()->with(['user', 'replies', 'replies.user'])->limit(6)->get();
        $reviews          = Review::where('software_id', $productDetails->id)->latest()->with('user')->limit(6)->get();
        $seoContents      = $this->seoContentSliced($productDetails->tag, $productDetails->name, $productDetails->description, getFilePath('software'), $productDetails->image, getFileSize('software'));
        $reviewPermission = $this->reviewPermission('software', $productDetails->id);

        static::clearSessionData();

        return view($this->activeTemplate . 'software.software_details', compact('pageTitle', 'productDetails', 'comments', 'reviews', 'reviewPermission', 'seoContents'));
    }

    public function job()
    {
        $pageTitle = 'Job';
        $query     = Job::active()->userActiveCheck()->checkData()->latest()->with(['user', 'user.level']);
        if (request()->skill) {
            $query->whereJsonContains('skill',request()->skill);
        }
        $products   = $query->paginate(getPaginate());
        $priceRange = $this->priceRangeCalc($products);
        $type       = 'job';
        return view($this->activeTemplate . 'home', compact('pageTitle', 'products', 'priceRange', 'type'));
    }

    public function jobDetails($slug, $id)
    {
        $pageTitle           = 'Job Details';
        $productDetails      = Job::where('id', $id)->active()->userActiveCheck()->checkData()->with('jobBidings', 'jobBidings.user', 'jobBidings.user.level')->firstOrFail();
        $comments            = Comment::where('job_id', $productDetails->id)->latest()->with(['user', 'replies', 'replies.user'])->limit(6)->get();
        $seoContents         = $this->seoContentSliced($productDetails->skill, $productDetails->name, $productDetails->description, getFilePath('job'), $productDetails->image, getFileSize('job'));
        $existingJobBidCheck = JobBid::where('job_id', $productDetails->id)->where('user_id', auth()->id() ?? 0 )->exists();
        return view($this->activeTemplate . 'job_details', compact('pageTitle', 'productDetails', 'comments', 'seoContents','existingJobBidCheck'));
    }

    public function fileDownload($fileName, $type)
    {

        try {
            $fileName = decrypt($fileName);
        } catch (Exception $ex) {
            $notify[] = ['error', "Invalid URL."];
            return back()->withNotify($notify);
        }
        if ($type == 'file') {
            $file = Software::where('software_file', $fileName)->firstOrFail();
            return response()->download(getFilePath('softwareFile') . '/' . $file->software_file);
        } elseif ($type == 'documentation') {
            $file = Software::where('document_file', $fileName)->firstOrFail();
            return response()->download(getFilePath('documentFile') . '/' . $file->document_file);
        } elseif ($type == 'workFile') {
            $file = WorkFile::where('file', $fileName)->firstOrFail();
            return response()->download(getFilePath('workFile') . '/' . $file->file);
        } elseif ($type == 'chatFile') {
            $file = Chat::where('file', $fileName)->firstOrFail();
            return response()->download(getFilePath('chatFile') . '/' . $file->file);
        } elseif ($type == 'messageFile') {
            $file = Message::where('file', $fileName)->firstOrFail();
            return response()->download(getFilePath('messageFile') . '/' . $file->file);
        } else {
            $notify[] = ['error', 'Invalid file download request'];
            return back()->withNotify($notify);
        }
    }

    public function publicProfile($username)
    {
        $pageTitle = 'User Profile';
        $user      = User::where('username', $username)->active()->with('jobBids')->firstOrFail();
        $services  = Service::where('user_id', $user->id)->active()->checkData()->latest()->limit(10)->with('user')->get();
        $softwares = Software::where('user_id', $user->id)->active()->checkData()->latest()->limit(10)->with('user')->get();
        $jobs      = Job::where('user_id', $user->id)->active()->checkData()->latest()->limit(10)->with('user')->get();
        $reviews   = Review::where('to_id', $user->id)->latest()->with('user')->limit(6)->get();

        return view($this->activeTemplate . 'public_profile', compact('pageTitle', 'user', 'services', 'softwares', 'jobs', 'reviews'));
    }

    public function adRedirect($id)
    {
        $id = decrypt($id);
        $ad = Advertisement::findOrFail($id);
        $ad->click += 1;
        $ad->save();

        if ($ad->type == 'image') {
            return redirect($ad->redirect_url);
        }

        return back();
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $blogs = Frontend::where('data_keys', 'blog.element')->paginate(getPaginate());
        $pageTitle = "Blogs";
        return view($this->activeTemplate . 'blogs', compact('blogs', 'pageTitle'));
    }

    public function blogDetails($slug, $id)
    {
        $blog        = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle   = 'Blog Details';
        $seoContents = $this->seoContentSliced($blog->meta_keywords, $blog->data_values->title, $blog->data_values->description, 'assets/images/frontend/blog/', $blog->data_values->image, '966x560');

        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'seoContents'));
    }

    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function subscriberStore(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $subscriber        = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => 'Subscribed successfully!']);
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);

        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);

        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;

        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general   = gs();

        if ($general->maintenance_mode == Status::DISABLE) {
            return to_route('home');
        }

        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    protected function priceRangeCalc($products)
    {
        $minPrice = count($products) ? intval($products->min('price')) : 0;
        $maxPrice = count($products) ? intval($products->max('price')) : 0;

        return [$minPrice, $maxPrice];
    }

    protected function seoContentSliced($keywords, $socialTitle, $description, $imagePath, $image, $imageSize)
    {
        $seoContents['keywords']           = $keywords ?? [];
        $seoContents['social_title']       = $socialTitle;
        $seoContents['description']        = strLimit(strip_tags($description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($description), 150);
        $seoContents['image']              = getImage($imagePath . '/' . $image, $imageSize);
        $seoContents['image_size']         = $imageSize;

        return $seoContents;
    }

    protected function reviewPermission($type, $id)
    {
        $result = false;

        if (auth()->check()) {
            $checkBooking = null;

            if ($type == 'service') {
                $checkBooking  = Booking::where('service_id', $id)->where('buyer_id',  auth()->id())->where('working_status', Status::WORKING_COMPLETED)->where('review_status', Status::NO)->first();
            } else {
                $checkBooking  = Booking::where('software_id', $id)->where('buyer_id',  auth()->id())->where('status', Status::BOOKING_PAID)->where('review_status', Status::NO)->first();
            }

            $result = $checkBooking ? $checkBooking : false;
        }

        return $result;
    }
}
