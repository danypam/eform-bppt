@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Viewing Submission #{{ $submission->id }} for form '{{ $submission->form->name }}'</h3>
                            </div>
                            <div class="panel-body">
                                <div class="btn-toolbar float-right" role="toolbar">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <a href="{{ route('formbuilder::forms.submissions.index', $submission->form->id) }}" class="btn btn-primary float-md-right btn-sm" title="Back To Submissions">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                <table class="table"  style="table-layout: fixed;font-family: sans-serif">

                                        <tbody style="border: none">
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Nama Lengkap</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->nama_lengkap}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Email</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->email}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>NIP</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->nip}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Kerja</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->unit_kerja->nama_unit}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Jabatan</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->unit_jabatan->unit}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>No HP</strong></td>
                                            <td>:</td>
                                            <td style="border: none;word-wrap: break-word; width: 50%">{{$identitas->no_hp}}</td>
                                        </tr>
{{--                                        --}}
                                        @foreach($form_headers as $header)
                                        <tr>
                                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong></td>
                                            <td>:</td>
                                            <td  style="border: none;word-wrap: break-word; width: 50%" class="float-right"><span>{{ $submission->renderEntryContent($header['name'], $header['type']) }}</span></td>
                                        </tr>
                                        @endforeach
                                        </tbody>

                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h5 class="card-title">Details</h5>
                            </div>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Form: </strong>
                                    <span class="float-right">{{ $submission->form->name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Submitted By: </strong>
                                    <span class="float-right">{{ $submission->user->name ?? 'Guest' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Last Updated On: </strong>
                                    <span class="float-right">{{ $submission->updated_at->toDayDateTimeString() }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Submitted On: </strong>
                                    <span class="float-right">{{ $submission->created_at->toDayDateTimeString() }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Diketahui By: </strong>
                                    <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($submission->mengetahui)->nama_lengkap)? \App\Http\Controllers\FormController::getNamePic($submission->mengetahui)->nama_lengkap:'' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Diketahui at: </strong>
                                    <span class="float-right">{{ isset($submission->mengetahui_at)? $submission->mengetahui_at: '' }}</span>
                                </li>
                                <li class="list-group-item"> {{--\App\Http\Controllers\FormController::getNamePic($pic)->nama_lengkap--}}
                                    <strong>Disetujui By: </strong>
                                    <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($submission->menyetujui)->nama_lengkap) ? \App\Http\Controllers\FormController::getNamePic($submission->menyetujui)->nama_lengkap: ''}}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Disetujui at: </strong>
                                    <span class="float-right">{{ isset($submission->menyetujui_at)? $submission->menyetujui_at: ''}}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>complete at: </strong>
                                    <span class="float-right">{{ isset($submission->complete_at)? $submission->complete_at: ''}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
