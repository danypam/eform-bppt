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
        /*table tr {
            text-align: center;
        }*/

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
    <table class="table table-borderless">
        <thead>
        <tr >
            <th scope="col" width="33%" ></th>
            <th scope="col" width="33%" ></th>
            <th scope="col" width="33%" ></th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-center">
            <td>                                       </td>
            <td> Mengetahui,                           </td>
            <td> Menyetujui,                           </td>
        </tr>
        <tr class="text-center">
            <td> Pemohon </td>
            <td> Ka. Unit Kerja/Atasan Langsung     </td>
            <td> Ka. Bidang Infrastruktur Informasi </td>
        </tr>
        <tr class="text-center" >
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr class="text-center" >
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr class="text-center" >
            <td> </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr class="text-center" >
            <td>__________________________</td>
            <td>__________________________</td>
            <td>__________________________</td>
        </tr>
        <tr class="text-center">
            <td class="col">                                       </td>
            <td class="col">                                       </td>
            <td class="col"> Amir Dahlan, S.T.,M. Kom              </td>
        </tr>
        </tbody>
    </table>

</div>

</body>
</html>




