<!doctype html>
<html lang="en">

<head>
    <title>E-FORM | SERVICE DESK BPPT</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <!-- VENDOR CSS -->--}}
    <meta name="userId" content="{{auth()->check() ? auth()->user()->id : ''}}">


{{--    <!-- VENDOR CSS -->--}}
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    @stack('styles')
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link  rel="stylesheet" href="{{asset('css/main.css')}}" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">


    <script>
        window.Laravel = {!! json_encode([
            'csrfToken'=>csrf_token(),
    ]) !!};
    </script>
    @yield('head')
{{--    @stack('styles')--}}
</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <div id="app">
    <!-- NAVBAR -->
@include('layouts.includes._navbar')
<!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
@include('layouts.includes._sidebar')
<!-- END LEFT SIDEBAR -->
    <!-- MAIN -->

@yield('content')

<!-- END MAIN -->
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">
            <p class="copyright">&copy; 2020 <a href="#" target="_blank"></a>. .</p>
        </div>
    </footer>
    </div>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script  src="{{asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}" defer></script>
<script  src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js" defer></script>
<script  src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script src="{{asset('js/progress-bar.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

{{--
<script src="{{asset('js/highcharts.js')}}"></script>
<script src="{{asset('js/highcharts-3d.js')}}"></script>
<script src="{{asset('js/exporting.js')}}"></script>
<script src="{{asset('js/export-data.js')}}"></script>
<script src="{{asset('js/accessibility.js')}}"></script>
--}}

{{--<script src="https://code.highcharts.com/stock/highstock.js" defer></script>
<script src="https://code.highcharts.com/stock/modules/data.js" defer></script>--}}


<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

@yield('footer')
<script>
    @if(Session::has('warning'))
    toastr.warning("{{Session::get('warning')}} <a href='/auth/ubahpass'>KLIK</a>", "Perhatian!",{timeOut: 50000})
    @endif
    @if(Session::has('sukses'))
    toastr.success("{{Session::get('sukses')}}", 'Sukses')
    @endif
    @if(Session::has('error'))
    toastr.error("{{Session::get('error')}}", 'Error')
    @endif
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

@stack('scripts')
</body>

</html>
