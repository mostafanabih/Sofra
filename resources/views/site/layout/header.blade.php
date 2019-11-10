<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@stack('title')</title>
    <!--title icon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('web/img/images/sofra logo-1.png')}}">
    <!--fontawesome css-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lemonada&display=swap" rel="stylesheet">
    <!--css bootstrap-->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!--my style-->
    <link href="{{asset('web/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/owl.carousel.min.css')}}" rel="stylesheet">

</head>
<!--fontawesome js-->
<script src="{{asset('web/js/all.min.js')}}"></script>



<body>


<!--================================START NAVBAR=================================-->
<nav class="navbar navbar-light bg-light row">

    <div class="navbar-search col-5">

        <a href="{{route('shoppingCart')}}" class="cart-link"><i class="fas fa-shopping-cart mx-2"></i>
            <span style="font-size: 18px">{{Session::has('cart') ? Session::get('cart')->totalAmount : ''}}</span>
        </a>


        <div class="dropdown mx-2">
             <span class="btn dropdown-toggle m-0" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </span>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                @if(auth()->guard('web-restaurant')->check())

                    @else
                <a class="dropdown-item" href="{{url(route('allRestaurants'))}}" style="display: inline-block">
                    <i class="fas fa-gift"></i>
                    المطاعم
                </a>

                <a class="dropdown-item" href="{{url(route('offers'))}}" style="display: inline-block">
                    <i class="fas fa-gift"></i>
                    العروض
                </a>
                    <a href="{{url(route('contact'))}}" class="dropdown-item" style="display: inline-block">
                        <i class="fas fa-envelope-square"></i>
                        تواصل معنا
                    </a>
                @endif
                @if(auth()->guard('web-client')->check())
                     <a class="dropdown-item" href="{{route('clientCurrentOrder')}}" style="display: inline-block">
                        <i class="fas fa-clipboard-list"></i>
                          طلباتى
                      </a>


                <a href="{{route('getProfile')}}" class="dropdown-item" style="display: inline-block">
                    <i class="far fa-user"></i>
                    حسابى
                </a>

                <a href="{{route('clientlogout')}}" class="dropdown-item" style="display: inline-block">
                    <i class="fas fa-sign-out-alt"></i>
                    تسجيل الخروج
                </a>
                    @endif
                @if(auth()->guard('web-restaurant')->check())
                        <a class="dropdown-item" href="{{route('myOrders')}}" style="display: inline-block">
                            <i class="fas fa-clipboard-list"></i>
                            طلباتى
                        </a>

                        <a class="dropdown-item" href="{{url(route('restaurantOffer'))}}" style="display: inline-block">
                            <i class="fas fa-gift"></i>
                            عروضي
                        </a>

                        <a href="{{route('resProfile')}}" class="dropdown-item" style="display: inline-block">
                            <i class="far fa-user"></i>
                             حسابي
                        </a>

                        <a href="{{route('resSeller')}}" class="dropdown-item" style="display: inline-block">
                            <i class="far fa-user"></i>
                            مطعمي
                        </a>

                        <a href="#" class="dropdown-item" style="display: inline-block">
                            <i class="fas fa-calculator"></i>
                            العمولة
                        </a>

                        <a href="#" class="dropdown-item" style="display: inline-block">
                            <i class="far fa-sticky-note"></i>
                            الطلبات المقدمة
                        </a>

                        <a href="{{route('restlogout')}}" class="dropdown-item" style="display: inline-block">
                            <i class="fas fa-sign-out-alt"></i>
                            تسجيل الخروج
                        </a>
                    @endif

            </div>
            <!--dropdown-menu-->
        </div>
        <!--dropdown-->



        <div class="search_box">
            <input type="search" class="form-control mr-sm-2">
            <i class="fas fa-search"></i>
        </div>

    </div>
    <!--navbar-search-->




    <a class="navbar-brand col-2" href="{{url(route('index'))}}"><img src="{{asset('web/img/images/sofra logo-1.png')}}"></a>


@if(auth()->guard('web-restaurant')->check())
        <div class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell" style="color: crimson"></i>
                <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"></span>
                <div class="dropdown-divider"></div>
                <p></p>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>

        </div>
@elseif(auth()->guard('web-client')->check())
        <div class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell" style="color: crimson"></i>
                <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </div>
    @else

    <button class="navbar-toggler col-4" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-hamburger"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{url(route('index'))}}">الرئيسية</a>
            </li>
        </ul>
    </div>
    <!--collapse-->
@endif
</nav>
<!--================================END NAVBAR=================================-->
