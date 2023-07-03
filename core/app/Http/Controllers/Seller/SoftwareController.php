<?php

namespace App\Http\Controllers\Seller;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Software;
use App\Models\SubCategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Software';
        $softwares  = Software::where('user_id', auth()->id())->latest()->with('category')->searchAble(['name'])->paginate(getPaginate());
        return view($this->activeTemplate . 'seller.software.index', compact('pageTitle', 'softwares'));
    }

    public function new()
    {
        $pageTitle  = 'New Software';
        $features   = Feature::active()->latest()->get();
        $categories = Category::active()->orderBy('name')->get()->map(function ($category) {
            $subcategories = SubCategory::active()->where('category_id', $category->id)->get();
            $category['subcategories'] = $subcategories;
            return $category;
        });

        return view($this->activeTemplate . 'seller.software.new', compact('pageTitle', 'features', 'categories'));
    }

    public function edit($slug, $id)
    {
        $pageTitle  = 'Edit Software';
        $software   = Software::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $features   = Feature::latest()->get();
        $categories = Category::orderBy('name')->with('subCategories',function($q){
            $q->active();
        })->get();
        return view($this->activeTemplate . 'seller.software.edit', compact('pageTitle', 'features', 'categories', 'software'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->softwareValidation($request, $id);
        $check = $this->checkData($request, $id);

        if ($check[0] == 'error') {
            $notify[] = $check;
            return back()->withNotify($notify);
        }

        if ($id) {
            $software     = Software::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            $notification = 'Software updated successfully';
        } else {
            $software          = new Software();
            $software->user_id = auth()->id();
            $notification      = 'Software added successfully';
        }

        if ($request->hasFile('image')) {
            $softwareImage   = fileUploader($request->image, getFilePath('software'), getFileSize('software'), @$software->image);
            $software->image = $softwareImage;
        }

        if ($request->hasFile('document_file')) {
            $softwareDocumentFile = fileUploader($request->document_file, getFilePath('documentFile'), null, @$software->document_file);
            $software->document_file = $softwareDocumentFile;
        }

        if ($request->hasFile('software_file')) {
            $softwareFile = fileUploader($request->software_file, getFilePath('softwareFile'), null, @$software->software_file);
            $software->software_file = $softwareFile;
        }

        $extraImage = $id ? $software->extra_image : [];

        if ($request->hasFile('extra_image')) {
            foreach ($request->extra_image as $singleImage) {
                $extraImage[] = fileUploader($singleImage, getFilePath('extraImage'), getFileSize('extraImage'));
            }
        }

        if(gs()->post_approval) {
            $software->status = Status::ENABLE;
        }

        $software->tag             = $request->tag;
        $software->name            = $request->name;
        $software->price           = $request->price;
        $software->features        = $request->features;
        $software->demo_url        = $request->demo_url;
        $software->extra_image     = $extraImage;
        $software->category_id     = $request->category_id;
        $software->description     = $request->description;
        $software->file_include    = $request->file_include;
        $software->sub_category_id = $request->sub_category_id;
        $software->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function salesLog()
    {
        $pageTitle   = 'Software Sale Logs';
        $softwareLog = Booking::where('software_id', '!=', 0)->where('seller_id', auth()->id())->where('status' , '!=', Status::BOOKING_UNPAID)->with('buyer')->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.software_log', compact('pageTitle', 'softwareLog'));
    }

    protected function softwareValidation($request, $id)
    {
        $fileValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'image'           => [$fileValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'extra_image.*'   => ['nullable', 'image', 'max:2048', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'document_file'   => [$fileValidation, new FileTypeValidate(['pdf'])],
            'software_file'   => [$fileValidation, new FileTypeValidate(['zip'])],
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'features.*'      => 'nullable|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'tag'             => 'required|array|min:3|max:15',
            'file_include'    => 'required|array|min:3|max:15',
            'demo_url'        => 'required|url',
            'description'     => 'required',
        ]);
    }

    protected function checkData($request, $id)
    {
        $category    = Category::query();
        $subcategory = SubCategory::query();
        $features    = Feature::query();

        if (!$id) {
            $category    = $category->active();
            $subcategory = $subcategory->active();
            $features    = $features->active();
        }

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

        return ['success'];
    }
}
