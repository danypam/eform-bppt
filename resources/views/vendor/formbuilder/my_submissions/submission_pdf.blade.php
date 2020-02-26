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
            @foreach($submission_data as $sub)
            <tr>
                <td >NIP</td>
                <td >: {{ $sub->nip }} / {{$sub->nip18}}</td>
            </tr>
            <tr>
                <td >Unit Kerja</td>
                <td >: {{ $sub->nama_unit }}</td>
            </tr>
            <tr>
                <td >No HP</td>
                <td >: {{ $sub->no_hp }}</td>
            </tr>
            @endforeach
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


@endsection
