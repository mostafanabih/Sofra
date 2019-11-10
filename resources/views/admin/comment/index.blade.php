@extends('layouts.app')
@inject('resturant','App\Models\Resturant')

@section('content')
    <section class="content-header">
        <h1>
            التعليقات والتقييم
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
            <li class="active">التعليقات والتقييم</li>
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
                @include('flash::message')
                @if(count($rules))
                    <div class="box-header">
                        <div class="card-tools col-md-8 pull-left">
                            {!! Form::open([
                                'action' => ['Admin\ReviewController@reviewsearch'],
                                'method' => 'get'
                            ]) !!}
                            <div class="form-group">
                                {!!Form::select('resturant_id',$resturant->get()->pluck('name','id')->toArray(),null,[
                                    'class' => 'form-control col-sm-5','placeholder'=>'المطعم'
                                ])!!}
                            </div>
                            <div class="input-group-append ">
                                <button type="submit" name="search" class="btn btn-danger"><i class="fa fa-search"></i></button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>التعليق</th>
                                <th> التقييم</th>
                                <th>المستخدم</th>
                                <th>المطعم</th>
                                <th >الحذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rules as $rule)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rule->comment}}</td>
                                    <td>{{$rule->rate}}</td>
                                    <td>{{optional($rule->client)->name}}</td>
                                    <td>{{optional($rule->resturant)->name}}</td>
                                    <td >
                                        {!! Form::open([
                                            'action' => ['Admin\ReviewController@destroy',$rule->id],
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
