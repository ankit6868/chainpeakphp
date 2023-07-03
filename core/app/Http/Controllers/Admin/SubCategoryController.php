<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::latest('id')->with('category')->filter(['category_id'])->paginate(getPaginate());
        $pageTitle     = "Manage Subcategories";
        $categories    = Category::active()->get();
        $countries     = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.category.sub_categories', compact('pageTitle', 'subcategories','categories'));
    }

    public function store(Request $request,$id = 0)
    {
        $imageValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'name'        => 'required|max:40',
            'category_id' => 'required|integer|exists:categories,id',
            'image'       => [$imageValidation, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        if ($id) {
            $subcategory  = SubCategory::findOrFail($id);
            $notification = 'Subcategory updated successfully';
        } else {
            $subcategory  = new SubCategory();
            $notification = 'Subcategory added successfully';
        }

        if ($request->hasFile('image')) {
            $imageFileName      = fileUploader($request->image, getFilePath('subcategory'), getFileSize('subcategory'), @$subcategory->image);
            $subcategory->image = $imageFileName;
        }

        $subcategory->name        = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();

        $notify[] = ['success', $notification];

        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return SubCategory::changeStatus($id);
    }
}
