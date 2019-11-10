@extends('layouts.app')
@inject('roles','App\Models\Role')
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
                    'action' => ['Admin\UserController@update',$model->id],
                    'method' => 'put'
                ])!!}

                <div class="form-group">
                    <label for="name">الإسم</label>
                    {!! Form::text('name',null,[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    {!! Form::email('email',null,[
                    'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="password">كلمه المرور</label>
                    {!! Form::password('password',[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="password_confirmation">تأكيد كلمه المرور</label>
                    {!! Form::password('password_confirmation',[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="roles_list">رتبه المستخدمين</label>
                    {!!Form::select('roles_list',$roles->pluck('display_name','id')->toArray(),null,[
                    'class' => 'form-control ',
                    'placeholder' => 'الرتبه'
                    ])!!}
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
