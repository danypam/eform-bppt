<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<style type="text/css">
    table tr{
        text-align: center;
    }
</style>

<table width="100%">
    <tr>
        <td width="80" align="left"><img src="{{ public_path('assets/img/picture1.png') }}" > <br></td>
    </tr>
</table>
<hr>
@yield('content')
<hr>
<br>
<br>

<table class="table table-borderless" text-align="center">
    <thead>
    <tr >
        <th scope="col">{{--created at--}}</th>
        <th scope="col">Mengetahui,</th>
        <th scope="col">Menyetujui,</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="100">Pemohon</td>
        <td width ="140" >Ka. Unit Kerja/Atasan Langsung </td>
        <td width ="140">Ka. Bidang Infrastruktur Informasi</td>
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
</table>


</body>
</html>
