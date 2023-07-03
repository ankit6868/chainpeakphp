<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Service;
use App\Models\Software;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    public function service()
    {
        $pageTitle   = 'Favorite Services';
        $favServices = Favorite::where('service_id', '!=', 0)->where('user_id', auth()->id())->latest()->with(['service', 'service.category'])->paginate(getPaginate());
        return view($this->activeTemplate . 'buyer.favorite.service', compact('pageTitle', 'favServices'));
    }

    public function software()
    {
        $pageTitle    = 'Favorite Softwares';
        $favSoftwares = Favorite::where('software_id', '!=', 0)->where('user_id', auth()->id())->latest()->with(['software', 'software.category'])->paginate(getPaginate());
        return view($this->activeTemplate . 'buyer.favorite.software', compact('pageTitle', 'favSoftwares'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'product_id' => 'required|integer|gt:0',
            'type'       => 'required|in:service,software',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $product     = null;
        $type        = $request->type;
        $productId   = $request->product_id;
        $authId      = auth()->id();
        $serviceId   = 0;
        $softwareId  = 0;

        if ($type == 'service') {
            $product = Service::where('id', $productId)->active()->userActiveCheck()->checkData()->first();
        } else {
            $product = Software::where('id', $productId)->active()->userActiveCheck()->checkData()->first();
        }

        if (!$product) {
            return response()->json(['error' => 'Item not found or disabled']);
        }

        if ($product->user_id == $authId) {
            return response()->json(['error' => 'This is your own product']);
        }

        $favoriteCheck = null;

        if ($type == 'service') {
            $favoriteCheck = Favorite::where('user_id', $authId)->where('service_id', $productId)->first();
            $serviceId = $product->id;
        } else {
            $favoriteCheck = Favorite::where('user_id', $authId)->where('software_id', $productId)->first();
            $softwareId = $product->id;
        }

        if ($favoriteCheck) {
            $favoriteCheck->delete();

            $product->favorite -= 1;
            $product->save();

            return response()->json([
                'favoriteCount' => $product->favorite,
                'success'       => 'Item removed from your favorite list successfully!'
            ]);

        } else {
            $favorite              = new Favorite();
            $favorite->user_id     = $authId;
            $favorite->service_id  = $serviceId;
            $favorite->software_id = $softwareId;
            $favorite->save();

            $product->favorite += 1;
            $product->save();

            return response()->json([
                'favoriteCount' => $product->favorite,
                'success'       => 'Item added to your favorite list successfully!'
            ]);
        }
    }
}
