@extends('layouts.pmi')

@section('content')

    <center>
        <h5>
            <strong>
                <u>{{ $submission->form->name }}</u>
                <br>
            </strong>
        </h5>
        <h5>
            {{ $submission->form->letter_code }}
        </h5>
    </center>

    <style type="text/css">
        table tr{
            text-align: left;
            word-wrap: break-word;
        }

    </style>
    <br>
    <p><b>IDENTITAS PEMOHON</b></p>
    <table class="table table-borderless table-sm" width="100%">

        <thead>
        <tr >
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td width ="50%">Nama Lengkap</td>
            <td width ="50%">: {{ $submission->user->name  }}</td>
        </tr>
        <tr>
            <td width ="50%">Email </td>
            <td width ="50%">: {{ $submission->user->email }}</td>
        </tr>
        @foreach($submission_data as $sub)
            <tr>
                <td width ="50%">NIP</td>
                <td width ="50%">: {{ $sub->nip }} / {{$sub->nip18}}</td>
            </tr>
            <tr>
                <td width ="50%">Unit Kerja</td>
                <td width ="50%">: {{ $sub->nama_unit }}</td>
            </tr>
            <tr>
                <td width="50%">No HP</td>
                <td width ="50%">: {{ $sub->no_hp }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>



    <p><b>DATA</b></p>
    <table class="table table-borderless table-sm" width="100%">

        <thead>
        <tr >
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($form_headers as $header)
            <tr>
                <td width="50%">{{ $header['label'] ?? title_case($header['name']) }} </td>
                <td width ="50%">: {{ $submission->renderEntryContent($header['name'], $header['type']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
