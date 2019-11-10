@extends('layouts.app')
@inject('perm','App\Models\Permission')

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
                    'action' => ['Admin\RoleController@update',$model->id],
                    'method' => 'put'
                ])!!}

                <div class="form-group">
                    <label for="name">الإسم</label>
                    {!! Form::text('name',null,[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="display_name">الإسم المعروض</label>
                    {!! Form::text('display_name',null,[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="description">الوصف</label>
                    {!! Form::textarea('description',null,[
                    'class'=>'form-control '
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="name">الإذن</label>
                    </br>
                    <input id="select-all" type="checkbox"><label for='select-all'>إختيار الكل</label>
                    <div class="row">
                        @foreach($perm->all() as $permission)
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permission_list[]" value="{{$permission->id}}"
                                               @if($model->hasPermission($permission->name))
                                               checked
                                            @endif
                                        > {{$permission->display_name}}


                                    </label>
                                </div>
                            </div>

                        @endforeach
                    </div>
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
