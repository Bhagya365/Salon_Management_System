@include('includes.header_account')



 
<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

<!-- Begin page -->

<!--Background Image-->
<div class="accountbg" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }} ');"> </div>


<div class="wrapper-page" >

    <div class="card custom-card custom-input">
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="index" class="logo logo-admin"><img src="assets/images/sources/logoRB.png" height="100" alt="logo"></a>
            </h3>

            <div class="p-3">
                <h4 class="gold-label font-18 m-b-5 text-center">Welcome Back !</h4>
                <p class=" gold-label text-center">Sign in to continue</p>

                @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ \Session::get('error') }}</p>
                    </div>
                @endif

                @if(\Session::has('warning'))
                    <div class="alert alert-warning alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ \Session::get('warning') }}</p>
                    </div>
                @endif


                <form class="form-horizontal m-t-30 text-white" action="{{ route('login') }}" method="POST">

                    <div class="form-group">
                        <label for="username" class="gold-label">Username</label>
                        <input type="text" class="form-control custom-input" id="username" name="username"
                               placeholder="Enter username">
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="pass" class="gold-label">Password</label>
                        <input type="password" class="form-control custom-input" id="password" name="password" placeholder="Enter password">
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>

                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                    <div class="form-group row m-t-20">
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input gold-checkbox" name="rememberme" id="customControlInline">
                                <label class="custom-control-label gold-label" for="customControlInline">Remember me</label>
                            </div>
                        </div>

                        <div class="col-sm-6 text-right">  <!-- text-right - button float to right -->                           
                            <button class="btn btn-gold-black" type="submit">Log In</button>
                        </div>

                        <!-- <div class="col-lg" align="right" style="padding-top: 10px;">
                            <a href="{{ route('clientInterface') }}" class="btn btn-gold-black">Back</a>
                        </div> -->

                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center gold-label">
        <p>Don't have an account ?
            <a href="{{route('clientSignup')}}" class="font-500 font-14 gold-white-label font-secondary "> Sign Up </a>
        </p>
        <p>
            <a href="{{route('clientInterface')}}" class="font-500 font-14 gold-white-label font-secondary "> Back </a>
        </p>

    </div>

</div>


@include('includes.footer_account')