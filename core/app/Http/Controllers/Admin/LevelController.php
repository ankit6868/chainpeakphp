<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function levelIndex()
    {
        $pageTitle = 'All Levels';
        $levels    = Level::orderBy('amount')->paginate(getPaginate());
        return view('admin.level', compact('pageTitle', 'levels'));
    }

    public function levelStore(Request $request, $id = 0)
    {
        $request->validate([
            'name'   => 'required|max:40',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($id) {
            $level         = Level::findOrFail($id);
            $notification  = 'Level updated successfully';
        } else {
            $level        = new Level();
            $notification = 'Level added successfully';
        }

        $level->name   = $request->name;
        $level->amount = $request->amount;
        $level->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Level::changeStatus($id);
    }
}
