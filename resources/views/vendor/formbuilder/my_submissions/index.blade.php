{{--@extends('formbuilder::layout')--}}
@extends('layouts.master')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <h1 class="card-title">
                                            {{ $pageTitle }} <span class="badge">{{ $submissions->count() }}</span>
                                        </h1>
                                    </div><br>

                                    @if($submissions->count())
                                        <div class="table-responsive">
                                            <table class="table" id="datatable">
                                                <thead>
                                                <tr>
                                                    <th class="five">NO</th>
                                                    <th class="">Form Type</th>
                                                    <th class="twenty-five">Status</th>
                                                    <th class="twenty-five">Catatan</th>
                                                    <th class="twenty-five">Created At</th>
                                                    <th class="fifteen">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($submissions as $submission)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $submission->form->name }}</td>
                                                        @if($submission->status == -1)
{{--                                                            <td><span class="label label-danger">REJECTED</span></td>--}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a type="button" class="label label-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Rejected
                                                                    </a>
                                                                    <div class="dropdown-menu" style="padding: 2px">
                                                                        <h6  class="dropdown-item">Permohonan anda telah ditolak </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($submission->status == 0)
{{--                                                            <td><span class="label label-primary">NEW</span></td>--}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a type="button" class="label label-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        New
                                                                    </a>
                                                                    <div class="dropdown-menu" style="padding: 2px">
                                                                        <h6  class="dropdown-item">Menunggu persetujuan atasan</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($submission->status == 1)
{{--                                                            <td><span class="label label-warning">PENDING</span></td>--}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a type="button" class="label label-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Pending
                                                                    </a>
                                                                    <div class="dropdown-menu" style="padding: 2px">
                                                                        <h6  class="dropdown-item">Menunggu persetujuan Kepala BII</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($submission->status == 2 || $submission->status == 3)
{{--                                                            <td><span class="label label-primary">ON GOING</span></td>--}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a type="button" class="label label-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        ON GOING
                                                                    </a>
                                                                    <div class="dropdown-menu" style="padding: 2px">
                                                                        <h6  class="dropdown-item">Permohonan Sedang Diproses</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if($submission->status == 4)
{{--                                                            <td><span class="label label-success">COMPLETE</span></td>--}}
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a type="button" class="label label-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Completed
                                                                    </a>
                                                                    <div class="dropdown-menu" style="padding: 2px">
                                                                        <h6  class="dropdown-item">Permohonan Telah Diproses</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                                @endif
                                                        <td>
                                                            @if($submission->status == -1)
                                                                @foreach($pegawai as $p)
                                                                    @if($p->id == $submission->rejected)
                                                                        <a href="#" data-id="{{$submission->submission_id}}" data-status="{{$p->nama_lengkap}}" data-ket="{{$submission->keterangan->ket}}" class="label label-default view" >LIHAT KETERANGAN</a>
                                                                    @endif
                                                                @endforeach
                                                            @elseif($submission->keterangan == null)
                                                                <a href="#" data-toggle="modal" data-target="#ket" data-id="{{$submission->submission_id}}" class="label label-default" >LIHAT KETERANGAN</a>
                                                            @else
                                                                <a href="#" data-toggle="modal" data-target="#ket" data-id="{{$submission->submission_id}}" data-ket1="{{$submission->keterangan->ket1}}" data-nama1="{{$submission->keterangan->nama1}}" data-ket2="{{$submission->keterangan->ket2}}" data-nama2="{{$submission->keterangan->nama2}}" data-ket3="{{$submission->keterangan->ket3}}" data-nama3="{{$submission->keterangan->nama3}}" class="label label-default" >LIHAT KETERANGAN</a>
                                                            @endif
{{--                                                            @if($submission->keterangan == null)--}}
{{--                                                            <a href="#" data-toggle="modal" data-target="#ket" data-id="{{$submission->submission_id}}" class="label label-default" >LIHAT KETERANGAN</a>--}}
{{--                                                            @else--}}
{{--                                                                @if($submission->status == -1)--}}
{{--                                                                    @foreach($pegawai as $p)--}}
{{--                                                                        @if($p->id == $submission->rejected)--}}
{{--                                                                            <a href="#" data-id="{{$submission->submission_id}}" data-status="{{$p->nama_lengkap}}" data-ket="{{$submission->keterangan}}" class="label label-default view" >LIHAT KETERANGAN</a>--}}
{{--                                                                        @endif--}}
{{--                                                                    @endforeach--}}
{{--                                                                @else--}}
{{--                                                                    <a href="#" data-toggle="modal" data-target="#ket" data-id="{{$submission->submission_id}}" data-ket1="{{$submission->keterangan->ket1}}" data-nama1="{{$submission->keterangan->nama1}}" data-ket2="{{$submission->keterangan->ket2}}" data-nama2="{{$submission->keterangan->nama2}}" data-ket3="{{$submission->keterangan->ket3}}" data-nama3="{{$submission->keterangan->nama3}}" class="label label-default" >LIHAT KETERANGAN</a>--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}

                                                        </td>
                                                            <td>{{ \App\Http\Controllers\TimeController::time_elapsed_string($submission->created_at->toDayDateTimeString()) }}</td>
                                                        <td>
                                                            <a href="{{ route('formbuilder::my-submissions.show', [$submission->id]) }}" class="btn btn-primary btn-sm" title="View submission">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                            <a href="/{{$submission->id}}/submission_pdf" class="btn btn-warning btn-sm" title="Export PDF">
                                                                <i class="fa fa-eye"></i> Export PDF
                                                            </a>
                                                            @if($submission->form->allowsEdit())
                                                                <a href="{{ route('formbuilder::my-submissions.edit', [$submission->id]) }}" class="btn btn-primary btn-sm" title="Edit submission">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif

                                                            {{-- <form action="{{ route('formbuilder::my-submissions.destroy', [$submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete this submission?" title="Delete submission">
                                                                    <i class="fa fa-trash-o"></i>
                                                                </button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($submissions->hasPages())
                                            <div class="card-footer mb-0 pb-0">
                                                <div>{{ $submissions->links() }}</div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="card-body">
                                            <h4 class="text-danger text-center">
                                                No submission to display.
                                            </h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CATATAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="" id="ket1" type="text" class="form-control" readonly placeholder="Tidak ada Catatan dari Atasan"></textarea>
                            <small for="exampleFormControlInput1" id="nama1"></small><hr>
                            <textarea name="" id="ket2" type="text" class="form-control" readonly placeholder="Tidak ada Catatan dari Kepala"></textarea>
                            <small for="exampleFormControlInput1" id="nama2"></small><hr>
                            <textarea name="" id="ket3" type="text" class="form-control" readonly placeholder="Tidak ada Catatan dari Pic"></textarea>
                            <small for="exampleFormControlInput1" id="nama3"></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('footer')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                autoWidth: false,
                scroller:    true,
            });
            $('#ket').on('show.bs.modal',function (event) {

                var button = $(event.relatedTarget)
                var keterangan1 = button.data('ket1')
                var nama1 = button.data('nama1')
                var keterangan2 = button.data('ket2')
                var nama2 = button.data('nama2')
                var keterangan3 = button.data('ket3')
                var nama3 = button.data('nama3')
                var modal = $(this)

                modal.find('.modal-body #ket1').val(keterangan1);
                modal.find('.modal-body #ket2').val(keterangan2);
                modal.find('.modal-body #ket3').val(keterangan3);

                $('#nama1').text('Ditambahkan oleh : '+nama1)
                $('#nama2').text('Ditambahkan oleh : '+nama2)
                $('#nama3').text('Ditambahkan oleh : '+nama3)

            });
            $('.view').click(function () {
                var span = document.createElement("span");
                span.innerHTML  ="<b>Ditambahkan Oleh :<b><br>" +$(this).attr('data-status');
                swal({
                    title: "KETERANGAN",
                    content: span,
                    html: true,
                    text: $(this).attr('data-ket')
            });
            });
        });
    </script>
@stop
