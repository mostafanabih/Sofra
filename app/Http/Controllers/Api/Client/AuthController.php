<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Client;
use App\Mail\ClientResetPassword;
use Hash;
use Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules =[
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'neighborhood_id' => 'required',
            'image' => 'required|file',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        else {
            $request->merge(['password'=> bcrypt($request->password)]);
            $client = Client::create($request->all());
            if ( $request->hasFile('image')  ) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/client', $image_new_name);
                $client->image = 'uploads/client/'.$image_new_name;
            }
            $client->api_token = str_random(60);
            $client->save();

            return jsonResponse(1,'تم التسجيل بنجاح',[
                'api_token'=>$client->api_token,
                'client'=>$client
            ]);
        }
    }

    public function login(Request $request){
        $rules =[
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return jsonResponse(0,$validator->errors()->first(),$validator->errors());
        }
        $client = Client::where('email',$request->email)->first();
        if ($client)
        {
            if (Hash::check($request->password,$client->password))
            {
                return jsonResponse(1,'تم تسجيل الدخول بنجاح',
                    [
                        'api_token'=>$client->api_token,
                        'client'=>$client
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
        $user = Client::where('phone',$request->phone)->first();
        //  return $user;
        if($user){
            $code = rand(1111,9999);
            $update = $user->update(['pin_code'=>$code]);
            if($update){
                Mail::to($user->email)
                    //  ->bcc('mabdo11112@gmail.com')
                    ->send(new ClientResetPassword($code));
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
        $user = Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();
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
        $data = $request->user('client')->tokens()->create($request->all());
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
