<?php

namespace App\Http\Controllers\Front;

use App\Mail\ResResetPassword;
use App\Models\Client;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\clResetPassword;
use Mail;
use Auth;


class AuthController extends Controller
{
    public function clientLogin()
    {
        return view('site.clientlogin');
    }
    public function clLogin()
    {
        $rememberme = request('rememberme') == 1 ? true : false;
        if (auth()->guard('web-client')->attempt(['email' => request('email'),
            'password' => request('password')], $rememberme)) {
            if(auth('web-client')->user()->status == 'deactive'){
                auth('web-client')->logout();
                flash('عذرا حدث خطا يرجي التواصل مع الاداره')->error();
                return back();
            }
                return redirect('user/index');
        } else {
            flash('يوجد خطا في البيانات الرجاء التاكد من البريد الالكتروني وكلمه المرور')->error();
            return back();
        }
    }

    public function getRegister()
    {
        return view('site.register-buyer');
    }
    public function clientRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|min:11|numeric',
            'password' => 'required|confirmed',
            'neighborhood_id' => 'required',
            'image' => 'required',
        ];
        $message = [
            'name.required' =>'إسم المستخدم مطلوب',
            'email.required' =>'البريد الإلكتروني مطلوب',
            'phone.required' =>'رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'password.required' =>'كلمه المرور مطلوبه',
            'neighborhood_id.required' =>'مطلوب إدخال الحي',
            'image.required' =>'صورة المستخدم مطلوبه',
        ];
        $this->validate($request,$rules,$message);
        $clients = Client::create($request->all());
        $clients->api_token = str_random(60);
        $clients->password =  bcrypt($request->password);
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/client', $image_new_name);
            $clients->image = 'uploads/client/'.$image_new_name;
        }
        $clients->save();
        if(auth('web-client')->attempt($request->only('email','password'))){
            return redirect('user/index');
        }else{
            return redirect('user/clientlogin');
        }

    }

    public function clGetEmail()
    {
        return view('site.reset.client-mail');
    }
    public function clSendEmail()
    {
        $this->validate(request(),[
            'email' => 'required'
        ]);
        $client = Client::where('email',request()->email)->first();
        if($client)
        {
            Mail::to($client->email)
                ->send(new clResetPassword);
            flash()->success('تم الارسال');
            return redirect(route('clientlogin'));
        }
        flash()->error('حدث خطأ حاول مره اخرى');
        return redirect(route('clientlogin'));
    }
    public function clResetPassword()
    {
        return view('site.reset.client-reset');
    }
    public function clNewPassword()
    {
        $this->validate(request(),[
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        $client = Client::where('email',request()->email)->first();
        if($client)
        {
            $client->password = bcrypt(request()->input('password'));
            $client->save();
            return redirect(route('clientlogin'));
        }else{
            flash()->error('حدث خطأ حاول مره اخرى');
            return redirect(route('clientlogin'));
        }
    }


    public function restaurantLogin()
    {
        return view('site.reslogin');
    }
    public function resLogin()
    {
        $rememberme = request('rememberme') == 1 ? true : false;
        if (auth()->guard('web-restaurant')->attempt(['email' => request('email'),
            'password' => request('password')], $rememberme)) {
                  return redirect('user/index');
        }
        else {
            flash('يوجد خطا في البيانات الرجاء التاكد من البريد الالكتروني وكلمه المرور')->error();
            return back();
        }
    }

    public function resGetRegister()
    {
        return view('site.register-seller');
    }
    public function restaurantRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:resturants',
            'phone' => 'required|min:11|numeric',
            'password' => 'required|confirmed',
            'neighborhood_id' => 'required',
            'image' => 'required',
            'delivery_fees' => 'required',
            'minimum' => 'required',
            'contact_phone' => 'required|min:11|numeric',
            'whats_app' => 'required|min:11|numeric',
        ];
        $message = [
            'name.required' =>'إسم المستخدم مطلوب',
            'email.required' =>'البريد الإلكتروني مطلوب',
            'phone.required' =>'مطلوب إدخال رقم الهاتف',
            'phone.min' =>'رقم الهاتف يجب ان لا يقل عن 11 رقم',
            'password.required' =>'كلمه المرور مطلوبه',
            'neighborhood_id.required' =>'مطلوب إدخال الحي',
            'image.required' =>'صورة المستخدم مطلوبه',
            'delivery_fees.required' =>'مطلوب إدخال رسوم التوصيل',
            'contact_phone.required' =>'مطلوب إدخال رقم الهاتف',
            'whats_app.required' =>'مطلوب إدخال رقم الهاتف',
        ];
        $this->validate($request,$rules,$message);
        $restaurants = Resturant::create($request->all());
        $restaurants->api_token = str_random(60);
        $restaurants->password =  bcrypt($request->password);
        $restaurants->categories()->attach($request->categories);
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/Restaurant', $image_new_name);
            $restaurants->image = 'uploads/Restaurant/'.$image_new_name;
        }
        $restaurants->save();
        if(auth('web-restaurant')->attempt($request->only('email','password'))){
            return redirect('user/index');
        }else{
            return redirect('user/restaurantlogin');
        }

    }

    public function resGetEmail()
    {
        return view('site.reset.restaurant-mail');
    }
    public function resSendEmail()
    {
        $this->validate(request(),[
            'email' => 'required'
        ]);
        $restaurant = Resturant::where('email',request()->email)->first();
        if($restaurant)
        {
            Mail::to($restaurant->email)
                ->send(new ResResetPassword);
            flash()->success('تم الارسال');
            return redirect(route('restaurantlogin'));
        }
        flash()->error('حدث خطأ حاول مره اخرى');
        return redirect(route('restaurantlogin'));
    }
    public function resResetPassword()
    {
        return view('site.reset.restaurant-reset');
    }
    public function resNewPassword()
    {
        $this->validate(request(),[
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        $restaurant = Resturant::where('email',request()->email)->first();
        if($restaurant)
        {
            $restaurant->password = bcrypt(request()->input('password'));
            $restaurant->save();
            return redirect(route('restaurantlogin'));
        }else{
            flash()->error('حدث خطأ حاول مره اخرى');
            return redirect(route('restaurantlogin'));
        }
    }

}
