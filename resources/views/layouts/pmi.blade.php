<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">{{--
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
--}}
</head>

<body>
    <style type="text/css">
        table tr{
            text-align: center;
        }

        table.table-borderless td, .table.table-borderless th {
            border: 0 !important;
        }
    </style>


    <table width="100%">
        <tr>
            <td width="80" align="left"><img src="{{ public_path('assets/img/picture1.png') }}" > <br></td>
        </tr>
    </table>
    <hr>
<div class="container">
    @yield('content')
    <br>
            {{--<div class="row-cols-3" >
                <div class="col">                                       </div>
                <div class="col"> Mengetahui,                           </div>
                <div class="col"> Menyetujui,                           </div>
            </div>
            <div class="row" >
                <div class="col"> Pemohon        </div>
                <div class="col"> Ka. Unit Kerja/Atasan Langsung        </div>
                <div class="col"> Ka. Bidang Infrastruktur Informasi    </div>
            </div>
            <div class="row">
                <div class="col"> __________________                    </div>
                <div class="col"> __________________                    </div>
                <div class="col"> __________________                    </div>
            </div>
            <div class="row" style="background-color: #2b542c">
                <div class="col">                                       </div>
                <div class="col">                                       </div>
                <div class="col"> Amir Dahlan, S.T.,M. Kom              </div>
            </div>--}}


    <table class="table table-borderless">
        <thead>
        <tr >
            <th scope="col-sm-4" ></th>
            <th scope="col-sm-4" ></th>
            <th scope="col-sm-4" ></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>                                       </td>
            <td> Mengetahui,                           </td>
            <td> Menyetujui,                           </td>
        </tr>

        </tbody>
    </table>

</div>

</body>
</html>




{{--<table class="table table-borderless" text-align="center">

    <thead>
    <tr >
        <th scope="col">--}}{{--created at--}}{{--</th>
        <th scope="col">Mengetahui,</th>
        <th scope="col">Menyetujui,</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td wi--}}{{--dth="100"--}}{{-->Pemohon</td>
        <td --}}{{--width ="140"--}}{{-- >Ka. Unit Kerja/Atasan Langsung </td>
        <td --}}{{--width ="140"--}}{{-->Ka. Bidang Infrastruktur Informasi</td>
    </tr>
    <tr>
        <td colspan="3" height ="70">  </td>
    </tr>
    <tr>
        <td>__________________</td>
        <td>__________________</td>
        <td>__________________</td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td> Amir Dahlan, S.T.,M. Kom </td>
    </tr>
    </tbody>
</table>--}}



