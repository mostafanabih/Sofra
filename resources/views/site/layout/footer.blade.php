<!--================================START FOOTER=================================-->

<footer>
    <div class="row m-0">
        <div class="col-md-4">
            <img src="{{asset('web/img/images/edit.png')}}">
            <h2>من نحن</h2>
            <p class="h5 mt-3"> {{settings()->about_app}}</p>
            <div class="social">
                <a href="{{settings()->instagram}}" target="_blank"><i class="fab fa-instagram fa-2x m-3"></i></a>
                <a href="{{settings()->twitter}}" target="_blank"><i class="fab fa-twitter fa-2x m-3"></i></a>
                <a href="{{settings()->facebook}}" target="_blank"><i class="fab fa-facebook-square fa-2x m-3"></i></a>
            </div>
            <!--social-->
        </div>
        <!--col-->
        <div class="offset-md-4"></div>
        <div class="col-md-4">
            <img src="{{asset('web/img/images/sofra logo-1@2x.png')}}" width="100%">
        </div>
        <!--col-->
    </div>
    <!--row-->
</footer>

<!--================================END FOOTER=================================-->

<script src="{{asset('web/JS/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('web/JS/popper.min.js')}}"></script>
<script src="{{asset('web/JS/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('web/JS/main.js')}}"></script>

@stack('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



</body>

</html>
