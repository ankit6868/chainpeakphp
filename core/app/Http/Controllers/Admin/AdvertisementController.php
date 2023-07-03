<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(getPaginate());
        $pageTitle      = 'All Advertisements';
        return view('admin.advertisement.index', compact('advertisements', 'pageTitle'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'type'         => 'required|in:image,script',
            'size'         => 'required_if:type,image|in:300x250,728x90',
            'script'       => 'required_if:type,script',
            'redirect_url' => 'required_if:type,image|url'
        ]);

        if ($request->type == 'image') {
            $size            = explode('x', $request->size);
            $imageValidation = $id ? 'nullable' : 'required';
            $request->validate([
                'image' => [$imageValidation, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif']), 'dimensions:width=' . $size[0] . ',height=' . $size[1]],
            ]);
        }

        if ($id) {
            $advertisement = Advertisement::findOrFail($id);
            $notification  = 'Advertisement updated successfully';

            if ($request->type == 'script') {
                if ($advertisement->type == 'image') {
                    fileManager()->removeFile(getFilePath('advertisement') . '/' . $advertisement->value);
                }
            }
            $value=$advertisement->value;
        } else {
            $advertisement = new Advertisement();
            $notification  = 'Advertisement added successfully';
        }


        if ($request->hasFile('image')) {
            $value = fileUploader($request->file('image'), getFilePath('advertisement'),null,@$advertisement->value);
        }

        if ($request->script) {
            $value = $request->script;
        }

        $advertisement->type         = $request->type;
        $advertisement->value        = $value;
        $advertisement->size         = $request->size;
        $advertisement->redirect_url = $request->type == 'image' ? $request->redirect_url : '#';
        $advertisement->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function remove($id)
    {
        $advertisement = Advertisement::findOrFail($id);

        if ($advertisement->type == 'image') {
            fileManager()->removeFile(getFilePath('advertisement') . '/' . $advertisement->value);
        }

        $advertisement->delete();

        $notify[] = ['success', 'Advertisement removed successfully'];
        return back()->withNotify($notify);
    }
}
