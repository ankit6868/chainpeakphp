<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Job;
use App\Models\Review;
use App\Models\Service;
use App\Models\Software;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FetchController extends Controller
{
    public function fetchReviews(Request $request , $id)
    {
        $validate = Validator::make($request->all(),[
            'skip' => 'required|integer|gt:0',
            'type' => 'required|in:service,software,profile',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $type = $request->type;
        $reviews = Review::query();

        if ($type === 'service') {
            $reviews  = $reviews->where('service_id', $id);
        } elseif ($type === 'software') {
            $reviews = $reviews->where('software_id', $id);
        } else {
            $reviews = $reviews->where('to_id', $id);
        }

        $reviews = $reviews->latest()->skip($request->skip)->with('user')->limit(5)->get();

        if (count($reviews)) {
            $view = view($this->activeTemplate . 'partials.load_reviews', compact('reviews'))->render();

            return response()->json([
                'success' => true,
                'html'    => $view
            ]);
        } else {
            return response()->json([
                'error' => 'No more reviews to show'
            ]);
        }
    }

    public function fetchComments(Request $request , $id)
    {
        $validate = Validator::make($request->all(),[
            'skip' => 'required|integer|gt:0',
            'type' => 'required|in:service,software,job',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $type = $request->type;
        $comments = Comment::query();

        if ($type === 'service') {
            $comments  = $comments->where('service_id', $id);
        } elseif ($type === 'software') {
            $comments = $comments->where('software_id', $id);
        } else {
            $comments = $comments->where('job_id', $id);
        }

        $comments = $comments->latest()->skip($request->skip)->with(['user', 'replies', 'replies.user'])->limit(5)->get();

        if (count($comments)) {
            $view = view($this->activeTemplate . 'partials.load_comment_reply', compact('comments'))->render();

            return response()->json([
                'success' => true,
                'html'    => $view
            ]);
        } else {
            return response()->json([
                'error' => 'No more comments to show'
            ]);
        }
    }

    public function fetchFeaturedServices(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'skip' => 'required|integer|gt:0',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $featuredServices = Service::active()->featured()->userActiveCheck()->checkData()->latest()->skip($request->skip)->with('user')->limit(5)->get();

        if (count($featuredServices)) {
            $view = view($this->activeTemplate . 'partials.load_featured_service', compact('featuredServices'))->render();

            return response()->json([
                'success' => true,
                'html'    => $view
            ]);
        } else {
            return response()->json([
                'error' => 'No more featured service to show'
            ]);
        }
    }

    public function fetchProducts(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'type'           => 'required|in:service,software,job',
            'skip'           => 'required|integer|gt:0',
            'search'         => 'nullable|string',
            'user_id'        => 'nullable|integer|gt:0',
            'category_id'    => 'nullable|integer|gt:0',
            'subcategory_id' => 'nullable|integer|gt:0',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $type          = $request->type;
        $search        = $request->search;
        $userId        = $request->user_id;
        $categoryId    = $request->category_id;
        $subcategoryId = $request->subcategory_id;

        if (!$search && !$userId && !$categoryId && !$subcategoryId) {
            return response()->json([
                'error' => 'Invalid action'
            ]);
        }

        if ($type == 'service') {
            $products = Service::query();
        } elseif ($type == 'software') {
            $products = Software::query();
        } else {
            $products = Job::query();
        }

        if ($search) {
            $products  = $products->searchable(['name'])->active()->userActiveCheck()->checkData();

        } elseif ($userId) {
            $products  = $products->where('user_id', $userId)->active()->checkData();

        } elseif ($categoryId) {
            $categoryCheck = Category::where('id', $categoryId)->active()->first();

            if (!$categoryCheck) {
                return response()->json([
                    'error' => 'Category not found or disabled'
                ]);
            }

            $products = $products->where('category_id', $categoryCheck->id)->active()->userActiveCheck()->whereHas('subCategory', function ($subCategory) {
                            $subCategory->active();
                        });

        } elseif ($subcategoryId) {
            $subcategoryCheck = SubCategory::where('id', $subcategoryId)->active()->whereHas('category', function($category) {
                                    $category->active();
                                })->first();

            if (!$subcategoryCheck) {
                return response()->json([
                    'error' => 'Subcategory not found or disabled'
                ]);
            }

            $products  = $products->where('sub_category_id', $subcategoryCheck->id)->active()->userActiveCheck();
        }

        $products = $products->latest()->skip($request->skip)->with('user')->limit(9)->get();

        if (count($products)) {
            if ($type == 'service') {
                $services = $products;
                $view     = view($this->activeTemplate . 'partials.load_services', compact('services'))->render();
            } elseif ($type == 'software') {
                $softwares = $products;
                $view      = view($this->activeTemplate . 'partials.load_softwares', compact('softwares'))->render();
            } else {
                $jobs = $products;
                $view = view($this->activeTemplate . 'partials.load_jobs', compact('jobs'))->render();
            }

            return response()->json([
                'success' => true,
                'html'    => $view
            ]);

        } else {
            return response()->json([
                'error' => 'No more items to show'
            ]);
        }
    }
}
