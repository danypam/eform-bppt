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
    table tr td{
        font-size: 8pt;
    }
    table tr th{
        font-size: 9pt;
    }
</style>
<table width="100%">
    <tr>
        <td width="80" align="left"><img src="{{ public_path('assets/img/favicon.png') }}" > <br></td>
        <td width="100%" align="center">
            <h6>BADAN PENGKAJIAN DAN PENERAPAN TEKNOLOGI</h6>
            <h6>( B P P T )</h6>
        </td>
    </tr>
</table>
<hr>

@yield('content')

</body>
</html>
