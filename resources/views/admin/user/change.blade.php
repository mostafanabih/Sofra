@extends('layouts.app')
@inject('model','App\User')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            تغيير كلمه المرور
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئسية</a></li>
            <li class="active"> تغيير كلمه المرور</li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">
    @include('partials.validationerrors')
    @include('flash::message')
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!!Form::model($model,[
                    'action' => 'Admin\UserController@changePassword',
                    'method' => 'post'
                ])!!}
                <div class="form-group">
                    <label for="old-password">كلمه المرور الحاليه</label>
                    {!! Form::password('old-password',[
                    'class'=>'form-control',
                    'placeholder'=>'كلمه المرور الحاليه'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="password">كلمه المرور الجديده</label>
                    {!! Form::password('password',[
                    'class'=>'form-control',
                    'placeholder'=>'كلمه المرور الجديده'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="password_confirmation">تأكيد كلمه المرور الجديده</label>
                    {!! Form::password('password_confirmation',[
                    'class'=>'form-control',
                    'placeholder'=>'تاكيد كلمه المرور الجديده'
                    ]) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="Submit">حفظ</button>
                </div>
                @push('scripts')
                    <script>
                        $("#select-all").click(function(){
                            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                        });
                    </script>
                @endpush

                {!!Form::close()!!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
