<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\{
    Models\Category,
    Http\Controllers\Controller,
};

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $pageTitle  = 'All Categories';
        $categories = Category::searchable(['name'])->latest()->withCount('subcategories')->paginate(getPaginate());
        return view('admin.category.categories', compact('pageTitle', 'categories'));
    }

    public function categoryStore(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|max:40'
        ]);

        if ($id) {
            $category         = Category::findOrFail($id);
            $notification     = 'Category updated successfully';
        } else {
            $category     = new Category();
            $notification = 'Category added successfully';
        }

        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Category::changeStatus($id);
    }
}
