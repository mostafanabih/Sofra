<?php

namespace App\Http\Controllers\Api\Resturant;

use App\Models\Resturant;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Mail\RestaurantResetPassword;
use Hash;
use Mail;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $records =[
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'neighborhood_id' => 'required',
            'image' => 'required|file',
            'delivery_fees' =>'required',
            'minimum' => 'required',
            'contact_phone' =>'required',
            'whats_app' => 'required',
            'category_id' => 'required',
            'state' => 'required|in:open,close',
        ];
        $validator = Validator::make($request->all(),$records);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else {
            $request->merge(['password'=> bcrypt($request->password)]);
            $restaurant = Resturant::create($request->all());
            $restaurant->categories()->attach($request->category_id);
            $restaurant->api_token = str_random(60);
            $restaurant->save();

            if ( $request->hasFile('image')  ) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/Restaurant', $image_new_name);
                $restaurant->image = 'uploads/Restaurant/'.$image_new_name;
                $restaurant->save();
            }

            return jsonResponse(1,'تم التسجيل بنجاح',[
                'api_token'=>$restaurant->api_token,
                'resturant'=>$restaurant
            ]);
        }
    }

    public function login(Request $request){
        $records =[
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(),$records);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Resturant::where('email',$request->email)->first();
        if ($restaurant)
        {
            if (Hash::check($request->password,$restaurant->password))
            {
                return jsonResponse(1,'تم تسجيل الدخول بنجاح',
                    [
                        'api_token'=>$restaurant->api_token,
                        'client'=>$restaurant
                    ]);
            }
            else
            {
                return jsonResponse(0,'البيانات المدخله غير صحيحه');
            }
        }
        else
        {
            return jsonResponse(0,'البيانات المدخله غير صحيحه');
        }
    }

    public function resetPassword(Request $request){
        $rules=[
            'phone' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $user = Resturant::where('phone',$request->phone)->first();
        //  return $user;
        if($user){
            $code = rand(1111,9999);
            $update = $user->update(['pin_code'=>$code]);
            if($update){
                Mail::to($user->email)
                    //  ->bcc('mabdo11112@gmail.com')
                    ->send(new RestaurantResetPassword($code));
                return jsonResponse(1, 'برجاء فحص هاتفك',[
                    'pin_code_for_reset'=>$code
                ]);
            }
            else{
                return jsonResponse(1,'حدث خطا حاول مره اخري');
            }
        }
        else{
            return jsonResponse(1,'رقم الهاتف غير صحيح');
        }
    }

    public function newpassword(Request $request){
        $rules=[
            'pin_code' => 'required',
            'password' =>'required|confirmed'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $user = Resturant::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();
        if($user){
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            if($user->save()){
                return jsonResponse(1,'تم تغيير كلمه المرور');
            }
            else{
                return jsonResponse(1,'حدث خطا حاول مره اخري');
            }
        }
        else{
            return jsonResponse(1,'هذا الكود غير صحيح');
        }
    }

    public function registerToken(Request $request){
        $rules = [
            'token' => 'required',
            'type' => 'required|in:android,ios'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        Token::where('token',$request->token)->delete();
        $data = $request->user('restaurant')->tokens()->create($request->all());
        return jsonResponse(1,'تم التسجيل بنجاح',$data);
    }
    public function removetoken(Request $request){
        $rules = [
            'token' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        Token::where('token',$request->token)->delete();
        return jsonResponse(1,'تم الحذف بنجاح');
    }

}
