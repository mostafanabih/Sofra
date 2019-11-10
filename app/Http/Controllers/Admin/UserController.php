<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UserResetPassword;
use Mail;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = User::paginate(5);
        return view('admin.user.index',compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =[
            'name' =>'required|unique:users,name',
            'email' =>'required|email|unique:users',
            'password' => 'required|confirmed',
            'roles_list'=>'required'

        ];

        $this->validate($request,$rules);
        $request->merge(['password'=> bcrypt($request->password)]);
        $user = User::create($request->all());
        $user->roles()->attach($request->roles_list);
        flash()->success("تم الإضافه بنجاح");
        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('admin.user.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules =[
            'name' =>'required',
            'email' =>'required',
        ];
        $this->validate($request,$rules);
        $data = User::findOrFail($id);
        $data->roles()->sync($request->input('roles_list'));
        $request->merge(['password'=> bcrypt($request->password)]);
        $data->update($request->all());
        flash()->success('تم التحديث بنجاح');
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        flash('تم الحذف بنجاح')->success();
        return redirect(route('user.index'));
    }

    public function change(){
        return view('admin.user.change');
    }
    public function changePassword(Request $request){
        $rules = [
            'old-password'=>'required',
            'password' => 'required|confirmed',
        ];
        $this->validate($request,$rules);
        $user = Auth::user();
        if (Hash::check($request->input('old-password'),$user->password)) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
            flash()->success('تم تحديث كلمه المرور');
            return back();
        }else {
            flash()->error('كلمه المرور غير صحيحه');
            return back();
        }
    }

    public function GetEmail()
    {
        return view('admin.user.email');
    }
    public function SendEmail()
    {
        $this->validate(request(),[
            'email' => 'required'
        ]);
        $user = User::where('email',request()->email)->first();
        if($user)
        {
            Mail::to($user->email)
                ->send(new UserResetPassword);
            flash()->success('تم الارسال');
            return redirect(url('login'));
        }
        flash()->success('حدث خطأ حاول مره اخرى');
        return redirect(url('login'));
    }
    public function ResetPassword()
    {
        return view('admin.user.resetpass');
    }
    public function NewPassword()
    {
        $this->validate(request(),[
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);
        $user = User::where('email',request()->email)->first();
        if($user)
        {
            $user->password = bcrypt(request()->input('password'));
            $user->save();
            return redirect(url('/'));
        }else{
            flash()->success('حدث خطأ حاول مره اخرى');
            return redirect(url('/'));
        }
    }
}
