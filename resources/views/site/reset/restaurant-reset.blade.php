@extends('site/layout/master')
@section('content')
    @push('title')
        إعاده تعيين كلمه السر
    @endpush
    <main class="register-bg">
        <section class="register">
            <div class="form-section">
                <img src="{{asset('web/img/images/user.png')}}" width="30%">
                @include('flash::message')
                <form method="post" action="{{route('postresNewPassword')}}">
                    @csrf
                    <div class="form-group">
                        <input type="email"  name="email" class="form-control @error('email') is-invalid @enderror" id="email"  placeholder="البريد الالكترونى">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control"  placeholder="كلمه المرور">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control"  placeholder="تاكيد كلمه المرور">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <span>إعاده تعيين كلمه المرور</span>
                    </button>

                </form>
            </div>

        </section>
    </main>



@endsection
