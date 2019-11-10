<?php

namespace App\Http\Controllers\Front;

use App\Models\ContactUs;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Resturant;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
class MainController extends Controller
{

    public function index()
    {
        $rules = Resturant::paginate(4);
        return view('site.index',compact('rules'));
    }


    public function searchrestaurant()
    {
        $rules = Resturant::where(function ($query) {
            if (request()->input('city_id')) {
                $query->whereHas('neighborhood', function ($q) {
                    $q->where('city_id', request()->city_id);
                });
            }
            if (request()->input('keyword')) {
                $query->where('name', 'like', '%' . request()->keyword . '%');
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد مطاعم')->error();
            return redirect(route('searchrestaurant'));
        } else {
            return view('site.allrestaurants', compact('rules'));
        }
    }


    public function allRestaurants(){
        $rules = Resturant::all();
        return view('site.allrestaurants',compact('rules'));
    }


    public function offers(){
        $now = Carbon::now()->toDate();
        $records = Offer::where('date_from','<',$now)->where('date_to','>',$now)->paginate(10);
        return view('site.offers', compact('records'));
    }


    public function contact(){
        return view('site.contact-us');
    }

    public function contactUs(Request $request){
        $rules = [
            'name' =>'required',
            'email' =>'required|email',
            'phone' =>'required|min:11|numeric',
            'message' =>'required',
            'problem_type' =>'required|in:inquiry,complaint,suggestion',
        ];
        $message = [
            'name.required' => 'اسم المستخدم مطلوب',
            'email.required' => 'مطلوب إدخال البريد الالكتروني',
            'phone.required' => 'مطلوب إدخال رقم الهاتف',
            'phone.min' => 'رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'message.required' => 'أدخل رسالتك',
            'problem_type.required' => 'ادخل نوع المشكله',
        ];
        $this->validate($request,$rules,$message);
        $contact = ContactUs::create($request->all());
        $contact->save();
        flash('تم إرسال الرساله بنجاح')->success();
        return back();

    }

    public function restaurantDetail($id){
        $detail = Resturant::find($id);
        $products = Product::where('resturant_id',$detail->id)->get();
        return view('site.restaurant',compact('detail','products'));
    }

    public function mealDetail($id){
        $products = Product::find($id);
        $foods = Product::where('resturant_id',$products->resturant_id)->get();
        $reviews = Review::where('resturant_id',$products->resturant_id)->get();
        return view('site.meal',compact('products','reviews','foods'));
    }

    public function getProfile(Request $request){
        $profile = $request->user('web-client');
        return view('site.my-account',compact('profile'));
    }

    public function clientProfile(Request $request){
        $rules =[
            'name' => 'required',
            'email' => 'required|email|unique:clients,id',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'neighborhood_id' => 'required',
        ];
        $message =[
            'name.required' =>'إسم المستخدم مطلوب',
            'email.required' =>'البريد الإلكتروني مطلوب',
            'phone.required' =>'رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'password.required' =>'كلمه المرور مطلوبه',
            'neighborhood_id.required' =>'مطلوب إدخال الحي',
        ];
        $this->validate($request,$rules,$message);
        $request->merge(['password'=> bcrypt($request->password)]);
        $request->user('web-client')->update($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/client', $image_new_name);
            $request->user('web-client')->update(['image' => 'uploads/client/' . $image_new_name]);
        }
        flash('تم التعديل بنجاح')->success();
        return back();

    }

    public function resProfile(Request $request){
        $profile = $request->user('web-restaurant');
        return view('site.res-account',compact('profile'));
    }

    public function restaurantProfile(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:resturants,id',
            'phone' => 'required|min:11|numeric',
            'neighborhood_id' => 'required',
            'delivery_fees' => 'required',
            'password' => 'required|confirmed',
            'minimum' => 'required',
            'state' => 'required',
            'contact_phone' => 'required|min:11|numeric',
            'whats_app' => 'required|min:11|numeric',
        ];
        $message = [
            'name.required' =>'إسم المستخدم مطلوب',
            'email.required' =>'البريد الإلكتروني مطلوب',
            'phone.required' =>'مطلوب إدخال رقم الهاتف',
            'phone.min' =>'رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'password.required' =>'مطلوب إدخال كلمه المرور',
            'neighborhood_id.required' =>'مطلوب إدخال الحي',
            'delivery_fees.required' =>'مطلوب إدخال رسوم التوصيل',
            'contact_phone.required' =>'مطلوب إدخال رقم الهاتف',
            'whats_app.required' =>'مطلوب إدخال رقم الهاتف',
            'state.required' =>'مطلوب إدخال الحاله',
        ];
        $this->validate($request,$rules,$message);
        $request->merge(['password'=> bcrypt($request->password)]);
        $request->user('web-restaurant')->update($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/Restaurant', $image_new_name);
            $request->user('web-restaurant')->update(['image' => 'uploads/Restaurant/' . $image_new_name]);
        }
        $request->user('web-restaurant')->categories()->sync($request->categories);

        flash('تم التعديل بنجاح')->success();
        return back();

    }

    public function restaurantOffer(Request $request){
        $offers = $request->user('web-restaurant')->offers()->get();
        return view('site.offers-seller',compact('offers'));
    }

    public function getOffer(){
        return view('site.add-offer');
    }

    public function addOffer(Request $request){
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'date_to' => 'required',
            'date_from' => 'required',
        ];
        $message = [
            'name.required' => 'مطلوب إدخال اسم العرض',
            'description.required' => 'مطلوب إدخال وصف العرض',
            'image.required' => 'مطلوب إدخال صورة العرض',
            'price.required' => 'مطلوب إدخال سعر العرض',
            'date_to.required' => 'مطلوب إدخال بدايه العرض',
            'date_from.required' => 'مطلوب إدخال نهايه العرض',
        ];
        $this->validate($request,$rules,$message);
        $offer = Offer::create($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/offers', $image_new_name);
            $offer->image = 'uploads/offers/'.$image_new_name;
        }
        $offer->resturant_id = auth('web-restaurant')->user()->id;
        $offer->save();
        flash('تم الإضافه بنجاح')->success();
        return redirect('user/restaurantOffer');
    }

    public function resSeller(Request $request){
        $restaurant = $request->user('web-restaurant');
        $products = Product::where('resturant_id',$restaurant->id)->get();
        return view('site.restaurant-seller',compact('restaurant','products'));
    }

    public function getProduct(){
        return view('site.add-product');
    }

    public function addProduct(Request $request){
        $rules = [
            'name' => 'required',
            'ingredients' => 'required',
            'image' => 'required',
            'price' => 'required',
            'order_process_time' => 'required',
            'price_on_offer' => 'required',
        ];
        $message = [
            'name.required' => 'مطلوب إدخال اسم العرض',
            'ingredients.required' => 'مطلوب إدخال وصف العرض',
            'image.required' => 'مطلوب إدخال صورة العرض',
            'price.required' => 'مطلوب إدخال سعر العرض',
            'order_process_time.required' => 'مطلوب إدخال بدايه العرض',
            'price_on_offer.required' => 'مطلوب إدخال نهايه العرض',
        ];
        $this->validate($request,$rules,$message);
        $product = Product::create($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/products', $image_new_name);
            $product->image = 'uploads/products/'.$image_new_name;
        }
        $product->resturant_id = auth('web-restaurant')->user()->id;
        $product->save();
        flash('تم الإضافه بنجاح')->success();
        return redirect('user/resSeller');
    }

    public function myOrders(Request $request){
        $neworders = $request->user('web-restaurant')->orders()->whereIn('state', ['pending'])->get();
        return view('site.my-orders',compact('neworders'));
    }

    public function currentOrder(Request $request){
        $currentorders = $request->user('web-restaurant')->orders()->whereIn('state', ['accepted'])->get();
        return view('site.current-order',compact('currentorders'));
    }

    public function pastOrder(Request $request){
        $pastorders = $request->user('web-restaurant')->orders()->whereIn('state', ['deliverd','declined'])->get();
        return view('site.past-Order',compact('pastorders'));
    }


    public function acceptOrder($id){
        $accept = request()->user('web-restaurant')->orders()->find($id);
        if ($accept) {
            $accept->update(['state' => 'accepted']);
            return back();
        }else{
            flash('عذرا حدث خطا')->error();
            return back();
        }
    }


    public function rejectOrder($id){
        $reject = request()->user('web-restaurant')->orders()->find($id);
        if ($reject) {
            $reject->update(['state' => 'rejected']);
            return back();
        }else{
            flash('عذرا حدث خطا')->error();
            return back();
        }
    }

    public function deliverOrder($id){
        $confirm = request()->user('web-restaurant')->orders()->find($id);
        if ($confirm) {
            $confirm->update(['state' => 'deliverd']);
            return back();
        }else{
            flash('عذرا حدث خطا')->error();
            return back();
        }
    }

    public function clientCurrentOrder(Request $request){
        $clientorders = $request->user('web-client')->orders()->whereIn('state', ['accepted'])->get();
        return view('site.my-orders-buyer',compact('clientorders'));
    }

    public function clientPastOrder(Request $request){
        $clientpasts = $request->user('web-client')->orders()->whereIn('state', ['deliverd','declined','rejected'])->get();
        return view('site.client-past-Order',compact('clientpasts'));
    }

    public function deliverdOrder($id){
        $accept = request()->user('web-client')->orders()->find($id);
        if ($accept) {
            $accept->update(['state' => 'deliverd']);
            return back();
        }else{
            flash('عذرا حدث خطا')->error();
            return back();
        }
    }

    public function decliendOrder($id){
        $reject = request()->user('web-client')->orders()->find($id);
        if ($reject) {
            $reject->update(['state' => 'declined']);
            return back();
        }else{
            flash('عذرا حدث خطا')->error();
            return back();
        }
    }

    public function getEditProduct($id){
        $model = Product::findOrFail($id);
        return view('site.edit-product',compact('model'));
    }

    public function editProduct(Request $request, $id){
        $rules = [
            'name' => 'required',
            'ingredients' => 'required',
            'price' => 'required',
            'order_process_time' => 'required',
            'price_on_offer' => 'required',
        ];
        $message = [
            'name.required' => 'مطلوب إدخال اسم العرض',
            'ingredients.required' => 'مطلوب إدخال وصف العرض',
            'price.required' => 'مطلوب إدخال سعر العرض',
            'order_process_time.required' => 'مطلوب إدخال بدايه العرض',
            'price_on_offer.required' => 'مطلوب إدخال نهايه العرض',
        ];
        $this->validate($request,$rules,$message);
        $product = Product::findOrFail($id);
        $product->update($request->all());

        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/products', $image_new_name);
            $product->update(['image' => 'uploads/products/' . $image_new_name]);
        }
        $product->resturant_id = auth('web-restaurant')->user()->id;
        $product->save();
        flash('تم التعديل بنجاح')->success();
        return redirect('user/resSeller');
    }


    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $product->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect('user/resSeller');
    }


    public function getEditOffer($id){
        $model = Offer::findOrFail($id);
        return view('site.edit-offer',compact('model'));
    }

    public function editOffer(Request $request, $id){
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'date_to' => 'required',
            'date_from' => 'required',
        ];
        $message = [
            'name.required' => 'مطلوب إدخال اسم العرض',
            'description.required' => 'مطلوب إدخال وصف العرض',
            'price.required' => 'مطلوب إدخال سعر العرض',
            'date_to.required' => 'مطلوب إدخال بدايه العرض',
            'date_from.required' => 'مطلوب إدخال نهايه العرض',
        ];
        $this->validate($request,$rules,$message);
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());

        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/offers', $image_new_name);
            $offer->update(['image' => 'uploads/offers/' . $image_new_name]);
        }
        $offer->resturant_id = auth('web-restaurant')->user()->id;
        $offer->save();
        flash('تم التعديل بنجاح')->success();
        return redirect('user/restaurantOffer');
    }


    public function deleteOffer($id){
        $offer = Offer::findOrFail($id);
        $offer->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect('user/restaurantOffer');
    }
//////////////////////////Start Cart//////////////////////////////////
    public function getAddToCart(Request $request,$id)
    {
        $product = Product::find($id);
        $restaurant = $product->resturant();
        if(session()->exists('resturant_id'))
        {

            if($restaurant->first()->id != session('resturant_id'))
            {
                flash()->error('error');
                return back();
            }
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        Cart::addRestaurantId($oldCart , $restaurant->first()->id);

        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
//        dd($request->session()->get('cart'));
        return redirect()->back();
    }

    public function shoppingCart()
    {
        if (!Session::has('cart')) {
            return view('site.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('site.shoppingCart', ['products' => $cart->products, 'total_Price' => $cart->total_Price]);

    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->products) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->route('shoppingCart');
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->products) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('shoppingCart');
    }

    public function addOrder(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'payment_method' => 'required',
        ]);
        $client =  auth()->guard('web-client')->user();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        if($oldCart == null || !Session::has('resturant_id'))
        {
            return redirect('/user/shoppingCart');
        }

        $products = new Cart($oldCart);

        $restaurant = Resturant::find(session('resturant_id'));

        if($restaurant)
        {
            $commission = settings()->commission * $products->total_Price;
            $net = $products->total_Price - $commission;
            $order = $client->orders()->create($request->all());
            $order2 = Order::find($order->id);
            $order2->update(
                [
                    'resturant_id' => $restaurant->id ,
                    'cost' => $products->total_Price,
                    'delivery_fees' => $restaurant->delivery_fees,
                    'payment_method' => $request->payment_method,
                    'total_price' => $products->total_Price + $restaurant->delivery_fees,
                    'commissin' => $commission,
                    'net' => $net,
                ]
            );
            foreach ($products->products as $product)
            {
                $order2->products()->attach($product['product_id'],
                    [
                        'amount' =>$product['amount'] ,
                        'price' =>$product['price'],
                        'special_order' =>$product['special_order']
                    ]);
            }
            session()->forget('cart');
            session()->forget('resturant_id');

            flash()->success('تم اضافة االطلب بنجاح');
            return back();
//            return view('site.shoppingCart', compact('order'));
        }
    }

    public function editShoppingCart($id)
    {
        $model = Order::findOrFail($id);
        return view('site.shoppingCart', compact('model'));
    }
    //////////////////////////End Cart//////////////////////////////////

    public function restaurantNotification(Request $request){
        $notifies = $request->user('web-restaurant')->notifications()->get();
        return view('site.index',compact('notifies'));
    }




}
