@extends('layouts.master')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Progress</h3>
                        <h5 class="right"> Permohonan ke- {{ $submission->id  }}</h5>
                    </div>
                    <div class="panel-body ">
                        <div class="progress-bar-wrapper"></div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Detail</h3>
                        <h5 class="right">Permohonan ke- {{ $submission->id  }}</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 mycontent-left">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                        <tr>
                                            <td><img src="{{ $identitas->foto? asset("/images/$identitas->foto") : asset("/images/user.png") }}"></td>
                                            <td>
                                                <h5> {{$submission->user->name}}</h5>
                                                <h5> {{$submission->user->email}}</h5>
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
                                            <td><h6>: {{$identitas->nip}}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>Unit Kerja</strong></h6></td>
                                            <td><h6>: {{$identitas->unit_kerja->unit}}</h6></td>
                                        </tr>
                                        <tr>

                                            <td><h6><strong>Unit Jabatan</strong></h6></td>
                                            <td><h6>: {{$identitas->unit_jabatan->unit}}</h6></td>
                                        </tr>
                                        <tr>
                                            <td><h6><strong>No Handphone</strong></h6></td>
                                            <td><h6>: {{$identitas->no_hp}}</h6></td>
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
                                                <span ><strong>Completed</strong> </span>
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
                                <h3 class="panel-title">Permohonan ke-{{ $submission->id }} dari Formulir '{{ $submission->form->name }}'</h3>
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

                                <div class="margin-top-30">

                                    @can('inbox-management')

                                        @if(!($submission->status == config("constants.status.rejected") || ($submission->status > config("constants.status.pending"))))
                                            @if(auth()->user()->can('inbox-approve-mengetahui') && $submission->status == config("constants.status.new"))
                                                <a href="#" data-toggle="modal" data-target="#approve" data-id="{{$submission->id}}" class="btn btn-primary btn-sm">Approve</a>
                                                <a href="#" data-toggle="modal" data-target="#edit" data-id="{{$submission->id}}" data-ket="{{$submission->keterangan}}" class="btn btn-danger btn-sm">Reject</a>
                                            @elseif(auth()->user()->can('inbox-approve-mengetahui') && auth()->user()->can('inbox-approve-menyetujui'))
                                                <a href="#" data-toggle="modal" data-target="#approve" data-id="{{$submission->id}}" data-ket="{{$submission->keterangan}}" class="btn btn-primary btn-sm">Approve</a>
                                                <a href="#" data-toggle="modal" data-target="#edit" data-id="{{$submission->id}}" data-ket="{{$submission->keterangan}}" class="btn btn-danger btn-sm">Reject</a>
                                            @elseif(auth()->user()->can('inbox-approve-menyetujui') && $submission->status == config("constants.status.pending"))
                                                <a href="#" data-toggle="modal" data-target="#approve1" data-id="{{$submission->id}}" data-ket="{{json_decode($submission->keterangan)->ket1}}" data-nama="{{json_decode($submission->keterangan)->nama1}}" class="btn btn-primary btn-sm">Approve</a>
                                                <a href="#" data-toggle="modal" data-target="#edit" data-id="{{$submission->id}}" data-ket="{{$submission->keterangan}}" class="btn btn-danger btn-sm">Reject</a>
                                            @endif
                                        @endif
                                    @endcan
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('inbox.update','test')}}" method="post">
                        {{method_field('patch')}}
                        {{csrf_field()}}
                        <input type="hidden" name="submission_id" id="id" value="" >
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Catatan</label>
                            <textarea name="keterangan[ket]" type="text" class="form-control" placeholder="Alasan di ditolak"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/submissions/approve" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="submission_id" id="id" value="" >
                        <input type="hidden" name="keterangan[nama1]" value="{{auth()->user()->name}}" >
                        <input type="hidden" name="keterangan[nama2]" value="" >
                        <input type="hidden" name="keterangan[nama3]" value="" >
                        {{--                        <div class="form-group">--}}
                        {{--                            <label for="exampleFormControlInput1">Keterangan Sebelumnya</label>--}}
                        {{--                            <textarea name="keterangan1" type="text" class="form-control" id="ket" readonly placeholder="Tidak ada keterangan"></textarea>--}}
                        {{--                        </div>--}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tambah Catatan</label>
                            <textarea name="keterangan[ket1]" type="text" class="form-control" placeholder="Silakan Isi Catatan Jika Diperlukan"></textarea>
                            <input type="hidden" name="keterangan[ket2]" value="" >
                            <input type="hidden" name="keterangan[ket3]" value="" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approve1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/submissions/approve" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="submission_id" id="id" value="" >
                        <input type="hidden" name="keterangan[nama1]" id="namaatasan" value="" >
                        <input type="hidden" name="keterangan[nama2]" value="{{auth()->user()->name}}" >
                        <input type="hidden" name="keterangan[nama3]" value="" >
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Catatan Atasan Langsung</label>
                            <textarea name="keterangan[ket1]" id="ket1" type="text" class="form-control" readonly placeholder="Tidak ada Catatan dari Atasan"></textarea>
                            <small for="exampleFormControlInput1" id="nama1"></small><hr>
                            <label for="exampleFormControlInput1">Tambah Catatan</label>
                            <textarea name="keterangan[ket2]" type="text" class="form-control" placeholder="Silakan Isi Catatan Jika Diperlukan"></textarea>
                            <input type="hidden" name="keterangan[ket3]" value="" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            var array = [ 'NEW <br><br> {!! $submission->created_at !!}', 'PENDING <br><br> {!! $submission->mengetahui_at !!}', 'ON GOING <br><br> {!! $submission->menyetujui_at !!}', 'COMPLETED <br><br> {!! $submission->complete_at !!}'];
            var status = {!! $submission->status !!};
            var mengetahui = {!! $submission->mengetahui !!} + '';
            var menyetujui = {!! $submission->menyetujui !!} + '';
            var wizard = '';
            if (status === 0){
                wizard = 'NEW <br><br> {!! $submission->created_at !!}';
            }else if(status === 1 || status === 2){
                wizard = 'PENDING <br><br> {!! $submission->mengetahui_at !!}';
            }else if(status === 3){
                wizard = 'ON GOING <br><br> {!! $submission->menyetujui_at !!}';
            }else if(status === 4){
                wizard = 'COMPLETED <br><br> {!! $submission->complete_at !!}';
            }else{
                if(mengetahui === 0){
                    array = [ 'REJECTED <br><br> {!! $submission->rejected_at !!}',  'PENDING', 'ON GOING', 'COMPLETED'];
                }else if(menyetujui === 0){
                    array = [ 'NEW <br><br> {!! $submission->created_at !!}', 'REJECTED <br><br> {!! $submission->rejected_at !!}', 'ON GOING', 'COMPLETED'];
                }
                wizard = 'REJECTED <br><br> {!! $submission->rejected_at !!}';
            }
            ProgressBar.singleStepAnimation = 1500;
            ProgressBar.init(
                array,
                wizard,
                'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
            );
        });
        $('#edit').on('show.bs.modal',function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var keterangan = button.data('ket')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #ket').val(keterangan);
        });
        $('#approve').on('show.bs.modal',function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
        });
        $('#approve1').on('show.bs.modal',function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var nama1 = button.data('nama')
            var keterangan1 = button.data('ket')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #ket1').val(keterangan1);
            modal.find('.modal-body #namaatasan').val(nama1);

            $('#nama1').text('Ditambahkan oleh : '+nama1)
        });

    </script>
@stop
