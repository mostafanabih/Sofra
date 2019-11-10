@extends('site/layout/master')
@section('content')
    @push('title')
        تسجيل دخول مستخدم جديد
    @endpush
    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                <img src="{{asset('web/img/images/user.png')}}" width="30%">
                @include('flash::message')
                {!! Form::open([
                      'action' => ['Front\AuthController@clLogin'],
                      'method' => 'post',
                      'class' => 'pt-3'
                      ]) !!}
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" id="exampleInputText1" aria-describedby="emailHelp" placeholder="البريد الالكترونى">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="كلمه المرور">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <span>دخول</span>
                    </button>
                    <div class="links py-5">
                        <a href="{{url(route('getRegister'))}}" class="newUser">
                            <h5>مستخدم جديد ؟</h5>
                        </a>
                        <a href="{{ route('postclResetPassword') }}" class="forgetPass">
                            <h5>نسيت كلمة السر ؟</h5>
                        </a>
                    </div>
                    <button type="button" class="btn btn-primary btn-lg m-3">
                       <a  href="{{url(route('getRegister'))}}"> <span>إنشأ حساب الان</span></a>
                    </button>
                {!! Form::close() !!}
            </div>

        </section>
    </main>



  @endsection
