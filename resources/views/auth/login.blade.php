<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login | E-FORM - Service Desk</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <div class="auth-box ">
                <div class="left">
                    <div class="content">
                        <div class="header">
                            <div class="logo text-center"><img src="{{asset('assets/img/logofix2.png')}}"  alt=""></div>
                            <p class="lead">Login to your account</p>
                            @if(Session::has('error'))
                                @if(isset($error) || Session::has('error') )
                                    <div class="alert alert-danger">
                                        <strong>Your Account is not Active!</strong><br> {{ isset($error) ? $info : Session::get('error') }}
                                    </div>
                                @endif
                            @endif
                        </div>
                        <form class="form-auth-small" action="/postlogin" method="POST">
                            {{csrf_field()}}
                            <div class="form-group{{$errors->has('email')? ' has-error':''}}">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input name="email" type="text" class="form-control" id="signin-email"  placeholder="Email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group{{$errors->has('password')? ' has-error':''}}">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input name="password" type="password" class="form-control" id="signin-password"  placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }} </span>
                                @endif
                            </div>
                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input type="checkbox">
                                    <span>Remember me</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>

                        </form>
                    </div>
                </div>
                <div class="right">
                    <div class="overlay" ></div>
                    <div class="content text">
                        <h1 class="heading">Elektronik Formulir Service Desk BPPT</h1>
                        <p>by developer team</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
</body>

</html>
