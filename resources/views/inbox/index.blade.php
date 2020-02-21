@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">INBOX</h3>
                                <ul class="nav nav-tabs">
                                    <li  class="active" id="tab-primary"><a href="#inbox">Primary</a></li>
                                    <li id="tab-approved"><a href="#inbox">Approved</a></li>
                                    <li id="tab-rejected"><a href="#inbox">Rejected</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                            {{--  primary  --}}
                                <div id="primary">
                                    <table class="table table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($primary_inboxs as $inbox)
                                            <tr>
                                                <td>{{$inbox->email}}</td>
                                                <td>{{$inbox->nama_lengkap}}</td>
                                                <td>{{$inbox->name}}</td>
                                                @if($inbox->status == -1)
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
                                                @if($inbox->status == 0)
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
                                                @if($inbox->status == 1)
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
                                                @if($inbox->status == 2 || $inbox->status == 3)
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
                                                @if($inbox->status == 4)
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
                                                <td>{{$inbox->keterangan}}</td>
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($inbox->created_at)}}</td>
                                                <td>
                                                    <a href="/forms/{{$inbox->form_id}}/submissions/{{$inbox->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                @can('inbox-management')

                                                        @if(!($inbox->status == config("constants.status.rejected") || ($inbox->status > config("constants.status.pending"))))
                                                            @if(auth()->user()->can('inbox-approve-mengetahui') && $inbox->status == config("constants.status.new"))
                                                                    <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm">Approve</a>
                                                                    <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm">Reject</a>

                                                            @elseif(auth()->user()->can('inbox-approve-mengetahui') && auth()->user()->can('inbox-approve-menyetujui'))
                                                                <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm">Approve</a>
                                                                <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm">Reject</a>

                                                            @elseif(auth()->user()->can('inbox-approve-menyetujui') && $inbox->status == config("constants.status.pending"))
                                                                <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm">Approve</a>
                                                                <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm">Reject</a>
                                                            @endif
                                                        @endif
                                                @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- approved --}}
                                <div id="approved" class="hidden">
                                    <table class="table table-hover datatable" >
                                        <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($approved_inboxs as $inbox)
                                            <tr>
                                                <td>{{$inbox->email}}</td>
                                                <td>{{$inbox->nama_lengkap}}</td>
                                                <td>{{$inbox->name}}</td>
                                                @if($inbox->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                @endif
                                                @if($inbox->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                @endif
                                                @if($inbox->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                @endif
                                                @if($inbox->status == 2 || $inbox->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                @endif
                                                @if($inbox->status == 4)
                                                    <td><span class="label label-success">COMPLETE</span></td>
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($inbox->created_at)}}</td>
                                                <td>
                                                    <a href="/forms/{{$inbox->form_id}}/submissions/{{$inbox->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                </td>
                                            </tr>
                                             @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Rejected  --}}
                                <div id="rejected" class="hidden">
                                    <table class="table table-hover datatable" >
                                        <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rejected_inboxs as $inbox)
                                            <tr>
                                                <td>{{$inbox->email}}</td>
                                                <td>{{$inbox->nama_lengkap}}</td>
                                                <td>{{$inbox->name}}</td>
                                                @if($inbox->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                @endif
                                                @if($inbox->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                @endif
                                                @if($inbox->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                @endif
                                                @if($inbox->status == 2 || $inbox->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                @endif
                                                @if($inbox->status == 4)
                                                    <td><span class="label label-success">COMPLETE</span></td>
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($inbox->created_at)}}</td>
                                                <td>
                                                    <a href="/forms/{{$inbox->form_id}}/submissions/{{$inbox->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                </td>
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

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
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
                            <label for="exampleFormControlInput1">Keterangan</label>
                            <textarea name="keterangan" type="text" class="form-control" placeholder="Alasan di ditolak"></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/submissions/approve" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="submission_id" id="id" value="" >
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Keterangan</label>
                            <textarea name="keterangan" type="text" class="form-control" placeholder="Silakan Isi Keterangan Jika Diperlukan"></textarea>
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

@stop
@section('footer')
    <script>
        /*tab*/
        $(document).ready(function () {
            {{--    togle tab--}}
            $('.datatable').DataTable();
            $( '#tab-approved' ).on('click', function() {
                $( "#primary" ).addClass( "hidden" );
                $( "#rejected" ).addClass( "hidden");
                $( "#approved" ).removeClass( "hidden");


                $( "#tab-approved" ).addClass( "active");
                $( "#tab-primary" ).removeClass( "active");
                $( "#tab-rejected" ).removeClass( "active");

            });
            $( "#tab-primary" ).on('click', function() {
                $( "#primary" ).removeClass( "hidden" );
                $( "#approved" ).addClass( "hidden" );
                $( "#rejected" ).addClass( "hidden" );

                $( "#tab-primary" ).addClass( "active");
                $( "#tab-approved" ).removeClass( "active");
                $( "#tab-rejected").removeClass( "active");
            });
            $( "#tab-rejected" ).on('click', function() {
                $( "#rejected" ).removeClass( "hidden" );
                $( "#approved" ).addClass( "hidden" );
                $( "#primary" ).addClass( "hidden" );

                $( "#tab-rejected" ).addClass( "active");
                $( "#tab-approved" ).removeClass( "active");
                $( "#tab-primary" ).removeClass( "active");
            });
            $('#datatable').DataTable({
            });
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
            var keterangan = button.data('ket')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #ket').val(keterangan);
        });
    </script>

@stop



