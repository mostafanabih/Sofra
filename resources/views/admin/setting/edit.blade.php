@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            تعديل
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i>الرئسية</a></li>
            <li class="active">تعديل</li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">
    @include('partials.validationerrors')
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
                    'action' => ['Admin\SettingController@update',$model->id],
                    'method' => 'put'
                ])!!}

                <div class="form-group">
                    <label for="about_app">حول التطبيق</label>
                    {!!Form::text('about_app',null,[
                        'class' => 'form-control'
                    ])!!}
                </div>
                <div class="form-group">
                    <label for="facebook"><i class="fa fa-facebook-square fa-2x" style="margin: 0 5px; color: #48759C;"></i></label>
                    {!! Form::text('facebook',null,[
                    'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="twitter"><i class="fa fa-twitter-square fa-2x" style="margin: 0 5px; color: #49C8DE;"></i></label>
                    {!! Form::text('twitter',null,[
                    'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="instagram"><i class="fa fa-instagram fa-2x" style="margin: 0 5px; color: #DE5849;"></i></label>
                    {!! Form::text('instagram',null,[
                    'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="Submit">حفظ</button>
                </div>

                {!!Form::close()!!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
