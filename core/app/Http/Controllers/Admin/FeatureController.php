<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Features';
        $features  = Feature::searchable(['name'])->latest()->paginate(getPaginate());
        return view('admin.features', compact('pageTitle', 'features'));
    }

    public function store(Request $request, $id = 0)
    {

        $request->validate([
            'name' => 'required|max:40'
        ]);

        if ($id) {
            $feature      = Feature::findOrFail($id);
            $notification = 'Feature updated successfully';
        } else {
            $feature      = new Feature();
            $notification = 'Feature added successfully';
        }

        $feature->name = $request->name;
        $feature->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Feature::changeStatus($id);
    }
}
