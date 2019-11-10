<?php

namespace App\Http\Controllers\Api\General;

use App\Models\Category;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\Neighborhood;
use App\Models\Offer;
use App\Models\Resturant;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class publicController extends Controller
{
    public function cities(){
        $cities = City::all();
       return JsonResponse(1,'success',$cities);
    }

    public function neighborhood(Request $request){
        $neighborhoods= Neighborhood::where(function($query) use($request){
            if ($request->has('city_id')) {
                $query->where('city_id',$request->city_id);
            }
        })->get();
        return jsonResponse(1,'success',$neighborhoods);
    }

    public function categories(){
        $categories = Category::all();
        return JsonResponse(1,'success',$categories);
    }

    public function restaurants()
    {
        $restaurants = Resturant::where(function ($query){
            if (request()->has('city_id'))
            {
                $query->whereHas('neighborhood', function ($q){
                    $q->where('city_id', request()->city_id);
                });
            }
            if (request()->has('keyword'))
            {
                $query->where('name', 'like', '%' . request()->keyword . '%');
            }
        })->get();
        return jsonResponse(1,'success',$restaurants);
    }

    public function getRestaurants(){
        $validator = Validator::make(request()->all(),[
            'restaurant_id' => 'required|exists:resturants,id'
        ]);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Resturant::where('id',request()->restaurant_id)->get();
        return jsonResponse(1,'success',$restaurant);
    }


    public function products(){
        $validator = Validator::make(request()->all(),[
            'restaurant_id' => 'required|exists:resturants,id'
        ]);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Resturant::where('id',request()->restaurant_id)->get();
        $products = Product::where('id',request()->restaurant_id)->get();
        return jsonResponse(1,'success',['restaurants'=>$restaurant,
            'products'=>$products]);
    }

    public function reviews(){
        $validator = Validator::make(request()->all(),[
            'restaurant_id' => 'required|exists:resturants,id'
        ]);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Resturant::where('id',request()->restaurant_id)->get();
        $reviews = Review::where('id',request()->restaurant_id)->get();
        return jsonResponse(1,'success',['restaurants'=>$restaurant,
            'reviews'=>$reviews]);
    }

    public function contacts(Request $request)
    {
        $rules =[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
            'problem_type' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else {
            $contacts = ContactUs::create($request->all());
            $contacts->save();
            return jsonResponse(1,'تم ارسال الرساله بنجاح',$contacts);
        }
    }

    public function offers(){
        $offers = Offer::orderBy('date_from','desc')->get();
        return jsonResponse(1,'success',$offers);
    }

    public function aboutApp(){
        $about_app = Setting::select('about_app')->get();
        return jsonResponse(1,'success',$about_app);
    }



}
