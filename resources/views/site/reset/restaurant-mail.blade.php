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
                <form method="post" action="{{route('postresResetPassword')}}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="البريد الالكترونى">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <span>إرسال</span>
                    </button>
                </form>
            </div>

        </section>
    </main>



@endsection
