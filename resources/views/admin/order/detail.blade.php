@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            طلبات الطعام
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> الرئيسيه</a></li>
            <li class="active">طلبات الطعام</li>
        </ol>
    </section>
    <section class="content" id="printableArea">


        <div class="box box-primary">
            <div class="box-body">

                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> تفاصيل طلب # {{$rules->id}}
                                <small class="pull-left"><i class="fa fa-calendar-o"></i> {{$rules->created_at}}
                                </small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">

                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> طلب من : {{$rules->client->name}} <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> الهاتف : {{$rules->client->phone}} <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> البريد الإلكترونى : {{$rules->client->email}}
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> عنوان العميل : {{$rules->client->neighborhood->city->name}} - {{$rules->client->neighborhood->name}}
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> عنوان الطلب : {{$rules->address}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">

                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i><strong>المطعم : {{$rules->resturant->name}}</strong><br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> البريد الإلكترونى : {{$rules->resturant->email}}<br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> الهاتف :{{$rules->resturant->phone}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b> رقم الفاتورة #{{$rules->id}}</b><br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>  تفاصيل الطلب: {{$rules->notes}} </b><br> {{-- --}}
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b> حالةالطلب:{{$rules->state}}</b>
                            <br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b> الإجمالى:</b> {{$rules->total_price}} ريال
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>إسم المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>ملاحظة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rules->products as $product)
                                    <tr>
                                        <td>1</td>
                                        <td>{{$product->name}}</td>
                                        <td>
                                            {{$product->pivot->amount}}
                                        </td>
                                        <td>{{$product->pivot->price}}</td>
                                        <td>{{$product->pivot->special_order}}</td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td>2</td>
                                    <td>تكلفة التوصيل</td>
                                    <td>-</td>
                                    <td>{{$rules->delivery_fees}}ريال </td>
                                    <td>-</td>
                                </tr>
                                <tr class="bg-success">
                                    <td>3</td>
                                    <td>الإجمالي</td>
                                    <td>-</td>
                                    <td>
                                        {{$rules->total_price}}    ريال
                                    </td>
                                    <td>-</td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="" class="btn btn-primary" onclick="printDiv('printableArea')" id="print-all">
                                <i class="fa fa-print"></i> {{trans('طباعه الطلب')}} </a>
                            <script>
                                function printDiv(divName) {
                                    var printContents = document.getElementById(divName).innerHTML;
                                    var originalContents = document.body.innerHTML;
                                    document.body.innerHTML = printContents;
                                    window.print();
                                    document.body.innerHTML = originalContents;
                                }
                            </script>
                            {{--                            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="{{trans('admin.print')}}" />--}}
                            {{--                            <br>--}}
                        </div>
                    </div>
                </section><!-- /.content -->
                <div class="clearfix"></div>

            </div>
        </div>


    </section>
@endsection
