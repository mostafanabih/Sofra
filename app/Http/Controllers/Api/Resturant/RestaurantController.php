<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class RestaurantController extends Controller
{
    public function offers(Request $request){
        $offers = $request->user()->offers()->get();
        return jsonResponse(1,'success',$offers);
    }

    public function createOffer(Request $request){
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else{
            $offer = Offer::create($request->all());
            if ( $request->hasFile('image')  ) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/offers', $image_new_name);
                $offer->image = 'uploads/offers/'.$image_new_name;
            }
            $offer->resturant_id = auth('restaurant')->user()->id;
            $offer->save();
            return jsonResponse(1,'success',$offer);
        }

    }

    public function editOffer(Request $request){
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else {
            $offers =$request->user()->offers()->find($request->id);
            if ($offers) {
                $offers->update($request->all());
                if ($request->hasFile('image')) {
                    $image = $request->image;
                    $image_new_name = time() . $image->getClientOriginalName();
                    $image->move('uploads/offers', $image_new_name);
                    $offers->update(['image' => 'uploads/offers/' . $image_new_name]);
                }
                $offers->resturant_id = auth('restaurant')->user()->id;
                $offers->save();
                return jsonResponse(1, 'success', $offers);
            }
            return jsonResponse(1, 'العرض غير موجود');
        }

    }

    public function removeOffer(Request $request){
        $rules = [
            'offer_id' => 'required|exists:offers,id'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $offers =$request->user()->offers()->find($request->offer_id);
            if ($offers){
                $offers->delete();
                return jsonResponse(1,'تم الحذف بنجاح');
            }
            return jsonResponse(0,'العرض غير موجود');
        }
    }

    public function products(Request $request){
        $products = $request->user()->products()->get();
        return jsonResponse(1,'success',$products);
    }

    public function createProduct(Request $request){
        $rules = [
            'name' => 'required',
            'ingredients' => 'required',
            'price' => 'required',
            'image' => 'required',
            'price_on_offer' => 'required',
            'order_process_time' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else{
            $product = Product::create($request->all());
            if ( $request->hasFile('image')  ) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/products', $image_new_name);
                $product->image = 'uploads/products/'.$image_new_name;
            }
            $product->resturant_id = auth('restaurant')->user()->id;
            $product->save();
            return jsonResponse(1,'success',$product);
        }

    }

    public function editProduct(Request $request){
        $rules = [
            'name' => 'required',
            'ingredients' => 'required',
            'price' => 'required',
            'price_on_offer' => 'required',
            'order_process_time' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else {
            $products =$request->user()->products()->find($request->id);
            if ($products) {
                $products->update($request->all());
                if ($request->hasFile('image')) {
                    $image = $request->image;
                    $image_new_name = time() . $image->getClientOriginalName();
                    $image->move('uploads/products', $image_new_name);
                    $products->update(['image' => 'uploads/products/' . $image_new_name]);
                }
                $products->resturant_id = auth('restaurant')->user()->id;
                $products->save();
                return jsonResponse(1, 'success', $products);
            }
        }

    }

    public function removeProduct(Request $request){
        $rules = [
            'product_id' => 'required|exists:products,id'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $products =$request->user()->products()->find($request->product_id);
            if ($products){
                $products->delete();
                return jsonResponse(1,'تم الحذف بنجاح');
            }
            return jsonResponse(0,'المنتج غير موجود');
        }

    }

    public function profile(Request $request){
        $profile = $request->user('restaurant');
        return jsonResponse(1,'success',$profile);
    }

    public function editProfile(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required',
            'phone' => 'required',
            'neighborhood_id' => 'required',
            'delivery_fees' =>'required',
            'minimum' => 'required',
            'contact_phone' =>'required',
            'whats_app' => 'required',
            'state' => 'required|in:open,close',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else{
            $request->merge(['password'=> bcrypt($request->password)]);
            $request->user('restaurant')->update($request->all());
            $request->user('restaurant')->categories()->sync($request->categories);
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/Restaurant', $image_new_name);
                $request->user()->update(['image' => 'uploads/Restaurant/' . $image_new_name]);
                $request->user()->save();
            }
            return jsonResponse(1,'تم التعديل بنجاح',[
                'restaurant' => $request->user('restaurant')
            ]);
        }
    }

    public function myReviews(Request $request){
        $myreviews = $request->user('restaurant')->reviews()->paginate(10);
        return jsonResponse(1,'success',$myreviews);
    }

    public function restaurantOrders(Request $request){
        $orders = $request->user('restaurant')->orders()->paginate(10);
        return jsonResponse(1,'success',$orders);
    }

    public function acceptOrder(Request $request){
        $rules = [
            'order_id' =>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $deliverd = $request->user('restaurant')->orders()->find($request->order_id);
            if ($deliverd){
                $deliverd->update(['state' => 'accepted']);
                $notification = $request->user('restaurant')->notifications()->create([
                    'title' => 'تم استلام الطلب',
                    'content' => 'تم استلام الطلب من المطعم'.$request->user()->name,
                    'order_id' => $deliverd->id,
                ]);
                $tokens = $request->user('restaurant')->tokens()->where('token','!=', null)->pluck('token')->toArray();
                if (count($tokens)) {
                    $title = $notification->title;
                    $body = $notification->body;
                    $dat = [
                        'order_id' => $deliverd->id
                    ];
                    $send = notifyByFirebase($title, $body, $tokens, $dat);
                    $send =json_decode($send);
                }
                return jsonResponse(1,'تم التعديل بنجاح');
            }
            return jsonResponse(0,'عذرا حدث خط');
        }
    }

    public function rejectOrder(Request $request){
        $rules = [
            'order_id' =>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $declined = $request->user('restaurant')->orders()->find($request->order_id);
            if ($declined){
                $declined->update(['state' => 'rejected']);
                $notification = $request->user('restaurant')->notifications()->create([
                    'title' => 'تم رفض الطلب',
                    'content' => 'تم رفض الطلب من المطعم'.$request->user()->name,
                    'order_id' => $declined->id,
                ]);
                $tokens = $request->user('restaurant')->tokens()->where('token','!=', null)->pluck('token')->toArray();
                if (count($tokens)) {
                    $title = $notification->title;
                    $body = $notification->body;
                    $dat = [
                        'order_id' => $declined->id
                    ];
                    $send = notifyByFirebase($title, $body, $tokens, $dat);
                    $send =json_decode($send);
                }
                return jsonResponse(1,'تم التعديل بنجاح');
            }
            return jsonResponse(0,'عذرا حدث خطا');
        }
    }

    public function newOrder(Request $request){
        $new = $request->user('restaurant')->orders()->whereIn('state', ['pending'])->get();
        return jsonResponse(1,'success',$new);
    }

    public function currentOrder(Request $request){
        $current = $request->user('restaurant')->orders()->whereIn('state', ['accepted'])->get();
        return jsonResponse(1,'success',$current);
    }

    public function pastOrder(Request $request){
        $past = $request->user('restaurant')->orders()->whereIn('state', ['deliverd','declined'])->get();
        return jsonResponse(1,'success',$past);
    }
    public function commission(Request $request)
    {
        $restaurant_total = $request->user()->orders()->where('state','deliverd')->sum('total_price') ;
        $app_commission = $request->user()->orders()->where('state','deliverd')->sum('commissin') ;
        $restaurant_payments = $request->user()->payments()->pluck('paid')->first();
        $rest =   $app_commission - $restaurant_payments ;
        $commission =  settings()->commission * 100 .' %';
        return jsonResponse(1,'success',[
            'restaurant total' => $restaurant_total,
            'app commission' => $app_commission,
            'restaurant payments' => $restaurant_payments,
            'rest' => $rest,
            'commission' => $commission,
        ]);
    }




}
