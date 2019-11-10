<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>سفرة</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/rtl/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/rtl/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/rtl/rtl.css')}}">
{{--    <link rel="stylesheet" href="{{ asset('dist/css/jquery-confirm.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.css')}}">--}}


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>سف</b>رة</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>سف</b>رة</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('admin/home')}}" class="nav-link">الصفحه الرئيسية</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url(route('contact.index'))}}" class="nav-link">تواصل معنا</a>
            </li>
            </ul>

            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{auth()->user()->name}}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" style="color: white"
                                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                                    <i  class="btn btn-danger btn-flat">تسجيل الخروج</i>
                                    </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-right image">
                    <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-right info">
                    <p>{{auth()->user()->name}}</p>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
            <li class="header"><i class="fa fa-dashboard"></i>لوحه التحكم</li>

            <li><a href="{{url(route('city.index'))}}"><i class="fa fa-building"></i> <span>المدن</span></a></li>
            <li><a href="{{url(route('neighborhood.index'))}}"><i class="fa fa-home"></i> <span>الأحياء</span></a></li>
            <li><a href="{{url(route('category.index'))}}"><i class="fa fa-bars"></i> <span>التصنيفات</span></a></li>
            <li><a href="{{url(route('review.index'))}}"><i class="fa fa-comments"></i> <span>التعليقات والتقييم </span></a></li>
            <li><a href="{{url(route('payment.index'))}}"><i class="fa fa-money"></i> <span>المدفوعات</span></a></li>
            <li><a href="{{url(route('offer.index'))}}"><i class="fa fa-shopping-bag"></i> <span>العروض</span></a></li>
            <li><a href="{{url(route('restaurant.index'))}}"><i class="fa fa-cutlery"></i> <span> المطاعم </span></a></li>
            <li><a href="{{url(route('client.index'))}}"><i class="fa fa-users"></i> <span> العملاء </span></a></li>
            <li><a href="{{url(route('order.index'))}}"><i class="fa fa-list-ol"></i> <span> الطلبات </span></a></li>
            <li><a href="{{url(route('contact.index'))}}"><i class="fa fa-phone"></i> <span>تواصل معنا</span></a></li>
            <li><a href="{{url(route('setting.index'))}}"><i class="fa fa-gears"></i> <span> الإعدادات </span></a></li>
            <li><a href="{{url(route('role.index'))}}"><i class="fa fa-user-times"></i> <span> رتب المستخدمين </span></a></li>
            <li><a href="{{url(route('user.index'))}}"><i class="fa fa-user-plus"></i> <span> المستخدمين </span></a></li>
            <li><a href="{{url('change')}}"><i class="fa fa-unlock-alt"></i> <span> تغيير كلمه المرور </span></a></li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.18
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
        reserved.
    </footer>
</div>


<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('dist/js/app.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
{{--<script src="{{asset('dist/js/jquery-confirm.min.js')}}"></script>--}}
{{--<script src="{{asset('js/abdo.js')}}"></script>--}}
{{--<script src="{{asset('js/jquery-confirm.js')}}"></script>--}}


@stack('scripts')
<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>
</body>
</html>
