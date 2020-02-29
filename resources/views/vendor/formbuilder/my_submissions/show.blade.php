@extends('layouts.master')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Progres</h3>
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
                                        <td><h6>{{$identitas->unit_kerja->unit}}</h6></td>
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
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Viewing Submission #{{ $submission->id }} for form '{{ $submission->form->name }}'</h3>
                            </div>
                            <div class="panel-body">
                                <div class="btn-toolbar float-right" role="toolbar">
                                </div>
                                <div class="form-container">
                                    <table class="table"  style="table-layout: fixed;font-family: sans-serif">

                                        <tbody style="border: none">
                                        @foreach($form_headers as $header)
                                            <tr>
                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>{{ $header['label'] ?? title_case($header['name']) }} </strong></td>
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
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            var array = [ 'NEW', 'PENDING', 'ON GOING', 'COMPLETED'];
            var status = {!! $submission->status !!};
            var mengetahui = {!! $submission->mengetahui !!} + '';
            var menyetujui = {!! $submission->menyetujui !!} + '';
            var wizard = '';
            if (status === 0){
                wizard = 'NEW <br><br> {!! $submission->created_at !!}';
            }    else if(status === 1 || status === 2){
                wizard = 'PENDING <br><br> {!! $submission->mengetahui_at !!}';
            }else if(status === 3){
                wizard = 'ON GOING';
            }else if(status === 4){
                wizard = 'COMPLETED';
            }else{
                if(mengetahui === 0){
                    array = [ 'REJECTED',  'PENDING', 'ON GOING', 'COMPLETED'];
                }else if(menyetujui === 0){
                    array = [ 'NEW', 'REJECTED', 'ON GOING', 'COMPLETED'];
                }
                wizard = 'REJECTED';
            }
            ProgressBar.singleStepAnimation = 1500;
            ProgressBar.init(
                array,
                wizard,
                'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
            );
        });

    </script>
@stop
