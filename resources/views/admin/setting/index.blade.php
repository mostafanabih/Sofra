@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            الإعدادات
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
            <li class="active">الإعدادات</li>
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
                     @foreach($rules as $rule)
                            <div class="col-md-12">

                                    <span><h4 style="color: red;"> حول التطبيق  </h4><b>{{$rule->about_app}}</b></span>
                                    <span><h4 style="color: red;"> بيانات التواصل :  </h4>
                                    <span><a href="{{$rule->facebook}}" target="_blank" style="margin: 0 5px; color: #48759C;" ><i class="fa fa-facebook-square fa-2x"></i></a></span>
                                    <span><a href="{{$rule->twitter}}" target="_blank" style="margin: 0 5px; color: #49C8DE;" ><i class="fa fa-twitter-square fa-2x"></i></a></span>
                                    <span><a href="{{$rule->instagram}}" target="_blank"  style="margin: 0 5px; color: #DE5849;"><i class="fa fa-instagram fa-2x"></i></a></span>
                                    </span>
                            </div>

                    <div class="col-md-12">
                        <hr/>
                        <p><b>تعديل البيانات :</b></p>
                        <a href="{{url(route('setting.edit',$rule->id))}}" class="btn btn-danger pull-right"><i class="fa fa-edit"></i> تعديل البيانات</a>
                    </div>
                    @endforeach


            </div>
            <!-- /.box-body -->
        </div>

        <!-- /.box -->

    </section>
@endsection
