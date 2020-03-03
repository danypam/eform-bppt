<!DOCTYPE html>
<html>
<head>
    <title>E-form Service Desk</title>
</head>
<body>
<h1>Hello, {{ $detail['name'] }}</h1>
<p class="h3"> There is one form to approved. Please check this link <a href="{{ $detail['url'] }}">http://inboxbyid</a> for approval</p>
<p class="h3"> Here is the data that need approval</p>

<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h2 class="panel-title">Viewing Submission #{{ $detail['submission']->id }} for form '{{ $detail['submission']->form->name }}'</h2>
                        </div>
                        <div class="panel-body">
                            <h3 class="card-title">Data Form</h3>

                            <div>
                                <table class="table"  style="table-layout: fixed;font-family: sans-serif">
                                    <tbody style="border: none">
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>Nama Lengkap</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->nama_lengkap}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>Email</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->email}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>NIP</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->nip}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Kerja</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->unit_kerja->nama_unit}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Jabatan</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->unit_jabatan->unit}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;word-wrap: break-word; width: 50%"><strong>No HP</strong></td>
                                        <td>:</td>
                                        <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->no_hp}}</td>
                                    </tr>
                                    {{--                                        --}}
                                    @foreach($detail['form_headers'] as $header)
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>{{ $header['label'] ?? title_case($header['name']) }} </strong></td>
                                            <td>:</td>
                                            <td  style="border: none;word-wrap: break-word; width: 50%" class="float-right"><span>{{ $detail['submission']->renderEntryContent($header['name'], $header['type']) }}</span></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Details</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Form: </strong>
                                <span class="float-right">{{ $detail['submission']->form->name }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Submitted By: </strong>
                                <span class="float-right">{{ $detail['submission']->user->name ?? 'Guest' }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Submitted On: </strong>
                                <span class="float-right">{{ $detail['submission']->updated_at->toDayDateTimeString() }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Last Updated On: </strong>
                                <span class="float-right">{{ $detail['submission']->created_at->toDayDateTimeString() }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Known by: </strong>
                                <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap)? \App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap:'' }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Known at: </strong>
                                <span class="float-right">{{ isset($detail['submission']->mengetahui_at)? $detail['submission']->mengetahui_at: '' }}</span>
                            </li>
                            <li class="list-group-item"> {{--\App\Http\Controllers\FormController::getNamePic($pic)->nama_lengkap--}}
                                <strong>Approved by: </strong>
                                <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap) ? \App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap: ''}}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Approved at: </strong>
                                <span class="float-right">{{ isset($detail['submission']->menyetujui_at)? $detail['submission']->menyetujui_at: ''}}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Completed at: </strong>
                                <span class="float-right">{{ isset($detail['submission']->complete_at)? $detail['submission']->complete_at: ''}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
