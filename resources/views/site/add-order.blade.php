@extends('site/layout/master')
@section('content')
    @push('title')
        شراء منتج
    @endpush

    <main class="register-bg">
        <section class="contact">
            <div class="form-section">
                <form class="pt-3" method="post" action="{{route('add-order')}}"
                      enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @include('flash::message')
                    <div class="form-group">
                        {!! Form::textarea('notes', null , [
                            'class' => 'form-control',
                            'placeholder' => 'ملاحظات'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="address" id="exampleInputText1"
                               aria-describedby="emailHelp" placeholder="العنوان">
                    </div>

                    <div class="form-group radio">
                        اون لاين<input type="radio"  name="payment_method" value="online">
                        كاش<input type="radio" name="payment_method"  value="cash">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg m-3">
                        <h5>انهاء الشراء</h5>
                    </button>

                </form>
            </div>

        </section>
    </main>
@endsection
