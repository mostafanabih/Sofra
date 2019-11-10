@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
             المستخدمين
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
            <li class="active"> المستخدمين</li>
        </ol>
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <a href="{{url(route('user.create'))}}" style="margin-bottom:10px;" class="btn btn-primary"><i class="fa fa-plus"></i>إضافة مستخدم</a>
                @include('flash::message')
                @if(count($rules))
                    <div class="table-responsive ">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الرتبه</th>
                                <th >التعديل</th>
                                <th >الحذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rules as $rule)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rule->name}}</td>
                                    <td>{{$rule->email}}</td>
                                    <td>@foreach($rule->roles as $role)
                                            {{$role->display_name}}
                                        @endforeach
                                    </td>
                                    <td >
                                        <a href="{{url(route('user.edit',$rule->id))}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td >
                                        {!! Form::open([
                                            'action' => ['Admin\UserController@destroy',$rule->id],
                                            'method' => 'delete'
                                        ]) !!}
                                        <button type="Submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data
                    </div>
                @endif
                {{$rules->render()}}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
@endsection
