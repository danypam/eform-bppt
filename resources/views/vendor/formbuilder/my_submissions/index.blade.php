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
                                                    <th class="twenty-five">Created At</th>
                                                    <th class="twenty-five">Keterangan</th>
                                                    <th class="fifteen">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($submissions as $submission)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $submission->form->name }}</td>
                                                        @if($submission->status == -1)
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
                                                                <td>{{ \App\Http\Controllers\TimeController::time_elapsed_string($submission->created_at->toDayDateTimeString()) }}</td>
                                                        <td><a href="#" class="label label-default view" data-ket="{{$submission->keterangan}}">LIHAT KETERANGAN</a></td>
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
@stop
@section('footer')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                autoWidth: false,
                scroller:    true,
            });
            $('.view').click(function () {
                swal("Keterangan", $(this).attr('data-ket'));
            });
        });
    </script>
@stop
