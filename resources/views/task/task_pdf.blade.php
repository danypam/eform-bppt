@extends('layouts.pmi')

@section('content')


    <center>
        <h4>
            <strong>
                <u>{{ $submission->form->name }}</u>
                <br>
            </strong>
        </h4>
        <h4>
            {{ $submission->form->letter_code }}
        </h4>
    </center>

    <style type="text/css">
        table tr{
            text-align: left;
            word-wrap: break-word;
        }


    </style>
    <br>


    <p><b>IDENTITAS PEMOHON</b></p>

    <table class="table table-borderless">
        <thead>
        <tr >
            <th scope="col" width="50%"></th>
            <th scope="col" width="50%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td >Nama Lengkap</td>
            <td >: {{ $submission->user->name  }}</td>
        </tr>
        <tr>
            <td >Email </td>
            <td >: {{ $submission->user->email }}</td>
        </tr>
            <tr>
                <td >NIP</td>
                <td >: {{ $identitas->nip }} / {{$identitas->nip18}}</td>
            </tr>
            <tr>
                <td >Unit Kerja</td>
                <td >: {{ $identitas->unit_jabatan->unit }}</td>
            </tr>
            <tr>
                <td >No HP</td>
                <td >: {{ $identitas->no_hp }}</td>
            </tr>
        </tbody>
    </table>

    <p><b>DATA</b></p>
    <table class="table table-borderless" >

        <thead>
        <tr >
            <th scope="col" width="50%"></th>
            <th scope="col" width="50%"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($form_headers as $header)
            <tr>
                <td>{{ $header['label'] ?? title_case($header['name']) }} </td>
                <td >: {{ $submission->renderEntryContent($header['name'], $header['type']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class="table table-borderless" style="outline-style: solid; outline-width: 2px">
        <thead>
            <tr >
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Notes : </strong></td>
            </tr>
            <tr>
                <td><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$submission->keterangan}}</i></td>
            </tr>
        </tbody>
    </table>


@endsection
