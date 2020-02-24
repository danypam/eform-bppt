@extends('formbuilder::layout')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Progress</h3>
                        <h5 class="right">No. Form: {{ $submission->id  }}</h5>
                    </div>
                    <div class="panel-body ">
                        <div class="progress-bar-wrapper"></div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Detail</h3>
                        <h5 class="right">No. Form: {{ $submission->id  }}</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 mycontent-left">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                        <tr>
                                            <td><img src="{{ $identitas->foto? asset("/images/$identitas->foto") : asset("/images/user.png") }}"></td>
                                            <td>
                                                <h5>{{$submission->user->name}}</h5>
                                                <h5>{{$submission->user->email}}</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>NIP</strong></h6></td>
                                            <td><h6>{{$identitas->nip}}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>Unit Kerja</strong></h6></td>
                                            <td><h6>{{$identitas->unit_kerja->nama_unit}}</h6></td>
                                        </tr>
                                        <tr>

                                            <td><h6><strong>Unit Jabatan</strong></h6></td>
                                            <td><h6>{{$identitas->unit_jabatan->unit}}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>No Hp</strong></h6></td>
                                            <td><h6>{{$identitas->no_hp}}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>Status</strong></h6></td>
                                            <td><h1 class="label label-default">{{config("constants.statusReverse.$submission->status")}}</h1></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                            <div class="col-md-6">
                                <ul class="events">
                                    @if($submission->created_at)
                                        <li>
                                            <time datetime="{{ $submission->created_at }}">{{ $submission->created_at }}</time>
                                            <span><strong>Form Dibuat</strong> </span>
                                        </li>
                                    @endif
                                        @if($submission->mengetahui)
                                            <li>
                                                <time class="seling">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</time>
                                                <span><h6>{{  \App\Http\Controllers\SubmissionController::duration($submission->created_at, $submission->mengetahui_at)}}</h6></span>
                                            </li>
                                            <li>
                                                <time datetime="{{ $submission->mengetahui_at }}">{{ $submission->mengetahui_at }}</time>
                                                <span>
                                                    <strong>Diketahui Oleh</strong>{{ \App\Http\Controllers\FormController::getNamePic($submission->mengetahui)->nama_lengkap }}
                                                </span>
                                            </li>
                                        @endif
                                        @if($submission->menyetujui)
                                            <li>
                                                <time class="seling">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</time>
                                                <span><h6>{{  \App\Http\Controllers\SubmissionController::duration($submission->mengetahui_at, $submission->menyetujui_at)}}</h6></span>
                                            </li>
                                            <li>
                                                <time datetime="{{ $submission->menyetujui_at }}">{{ $submission->menyetujui_at }}</time>
                                                <span><strong>Disetujui Oleh</strong>{{ \App\Http\Controllers\FormController::getNamePic($submission->menyetujui)->nama_lengkap }}</span>
                                            </li>
                                        @endif
                                        @if($submission->pic)
                                            <li>
                                                <time class="seling">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</time>
                                                <span><h6>{{  \App\Http\Controllers\SubmissionController::duration($submission->menyetujui_at, $submission->pic_at)}}</h6></span>
                                            </li>
                                            <li>
                                                <time datetime="{{ $submission->pic_at }}">{{ $submission->pic_at }}</time>
                                                <span><strong>Dikerjakan Oleh</strong> {{ \App\Http\Controllers\FormController::getNamePic($submission->pic)->nama_lengkap }}</span>
                                            </li>

                                        @endif
                                        @if($submission->complete_at)
                                            <li>
                                                <time class="seling">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;</time>
                                                <span><h6>{{  \App\Http\Controllers\SubmissionController::duration($submission->pic_at, $submission->complete_at)}}</h6></span>
                                            </li>
                                            <li>
                                                <time datetime="{{ $submission->complete_at }}">{{ $submission->complete_at }}</time>
                                                <span ><strong>Complete</strong> </span>
                                            </li>
                                        @endif
                                        @if($submission->rejected)
                                            <li>
                                                <time datetime="{{ $submission->rejected_at }}">{{ $submission->rejected_at }}</time>
                                                <span><strong>Form Ditolak Oleh</strong> {{ \App\Http\Controllers\FormController::getNamePic($submission->rejected)->nama_lengkap }}</span>
                                            </li>
                                        @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <form action="{{ route('formbuilder::forms.submissions.destroy', [$submission->form, $submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm rounded-0 confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete submission" title="Delete this submission?">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($form_headers as $header)
                                        <li class="list-group-item">
                                            <strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong>
                                            <span class="float-right">
                                                    {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                                                </span>
                                        </li>
                                    @endforeach
                                </ul>
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
