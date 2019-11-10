<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Order;
use App\Models\Product;
use App\Models\Resturant;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ClientController extends Controller
{
    public function newOrder(Request $request){
        $validator = Validator::make($request->all(),[
            'resturant_id' => 'required|exists:resturants,id',
            'products.*.product_id' =>'required|exists:products,id',
            'products.*.amount' =>'required',
            'address' => 'required',
            'payment_method' => 'required|in:cash,online',
        ]);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Resturant::find($request->resturant_id);
        if($restaurant->state == 'close'){
            return jsonResponse(0,'عذرا المطعم غير متاح في الوقت الحالي');
        }
        $order = $request->user()->orders()->create([
           'resturant_id' => $request->resturant_id,
           'notes' => $request->notes,
           'state' => 'pending',
           'address' => $request->address,
           'payment_method' => $request->payment_method,
        ]);
        //dd($order);
        $cost = 0;
        $delivery_fees = $restaurant->delivery_fees;
        foreach ($request->products as $p)
        {
            $product = Product::find($p['product_id']);
            //dd($product);
            $readyProduct = [
                $p['product_id'] => [
                    'amount' => $p['amount'],
                    'price' => $product->price,
                    'special_order' => (isset($p['special_order'])) ? $p['special_order'] : ''
                ]
            ];
            $order->products()->attach($readyProduct);
            $cost += ($product->price * $p['amount']);
            if($cost >= $restaurant->minimum)
            {
                $total = $cost + $delivery_fees;
                $commission = settings()->commission * $cost;

                $net = $total - $commission;
                 $order->update([
                   'cost' => $cost,
                   'delivery_fees' => $delivery_fees,
                    'total_price' => $total,
                    'commissin' => $commission,
                    'net' => $net,
                ]);
                $notification = $restaurant->notifications()->create([
                     'title' => 'لديك طلب جديد',
                     'content' => 'لديك طلب جديد من العميل'.$request->user()->name,
                     'order_id' => $order->id,
                 ]);
                 $tokens = $restaurant->tokens()->where('token','!=', null)->pluck('token')->toArray();
                if (count($tokens)) {
                    $title = $notification->title;
                    $body = $notification->body;
                    $dat = [
                        'order_id' => $order->id
                    ];
                    $send = notifyByFirebase($title, $body, $tokens, $dat);
                    $send =json_decode($send);
                }
                $data = [
                    'order' => $order->fresh()->load('products')
                ];
                return jsonResponse(1,'تم الطلب بنجاح',$data);
            }else{
                $order->products()->delete();
                $order->delete();
                return jsonResponse(0,'ريال'.$restaurant->minimum.'الطلب لابد ان يكون اقل من ');
            }
        }
    }

    public function profile(Request $request){
        $profile = $request->user('client');
        return jsonResponse(1,'success',$profile);
    }

    public function editProfile(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required',
            'neighborhood_id' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else{
            $request->merge(['password'=> bcrypt($request->password)]);
            $request->user('client')->update($request->all());
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/client', $image_new_name);
                $request->user()->update(['image' => 'uploads/client/' . $image_new_name]);
                $request->user()->save();
            }
            return jsonResponse(1,'تم التعديل بنجاح',[
                'restaurant' => $request->user('client')
            ]);
        }
    }

    public function orderDetails(Request $request){
        $orderDetails = $request->user('client')->orders()->find($request->order_id);
        if ($orderDetails){
            return jsonResponse(1,'success',$orderDetails->load('products'));
        }
        return jsonResponse(1,'عذرا لا يوجد طلبات');
    }

    public function myorders(Request $request){
        $myorders = $request->user('client')->orders()->paginate(10);
        return jsonResponse(1,'success',$myorders);
    }

    public function deliverdOrder(Request $request){
        $rules = [
           'order_id' =>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $deliverd = $request->user('client')->orders()->find($request->order_id);
            if ($deliverd){
                $deliverd->update(['state' => 'deliverd']);
                $notification = $request->user('client')->notifications()->create([
                    'title' => 'تم استلام الطلب',
                    'content' => 'تم استلام الطلب من العميل'.$request->user()->name,
                    'order_id' => $deliverd->id,
                ]);
                $tokens = $request->user('client')->tokens()->where('token','!=', null)->pluck('token')->toArray();
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

    public function declinedOrder(Request $request){
        $rules = [
            'order_id' =>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $declined = $request->user('client')->orders()->find($request->order_id);
            if ($declined){
                $declined->update(['state' => 'declined']);
                return jsonResponse(1,'تم التعديل بنجاح');
            }
            return jsonResponse(0,'عذرا حدث خطا');
        }
    }

    public function addReview(Request $request){
        $rules = [
            'resturant_id' => 'required',
            'comment' => 'required',
            'rate' => 'required|in:1,2,3,4,5',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }else{
            $reviews = Review::create($request->all());
            $reviews->client_id = auth('client')->user()->id;
            $reviews->save();
            return jsonResponse(1,'success',$reviews);
        }
    }

    public function currentOrder(Request $request){
        $current = $request->user('client')->orders()->whereIn('state', ['accepted'])->get();
        return jsonResponse(1,'success',$current);
    }

    public function pastOrder(Request $request){
        $past = $request->user('client')->orders()->whereIn('state', ['deliverd','declined','rejected'])->get();
        return jsonResponse(1,'success',$past);
    }



}
