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
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
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
                                    @foreach($inboxs as $inbox)
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
                                                @can('inbox-management')
                                                    @if($inbox->status == -1)
                                                        <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm hidden">Approve</a>
                                                        <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm hidden">Reject</a>
                                                    @else
                                                        <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm">Approve</a>
                                                        <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm">Reject</a>
                                                    @endif
                                                @endcan
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


@stop
@section('footer')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({

            });

            $('.delete').click(function () {
                var peg_id = $(this).attr('pegawai-id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Poof! Your data has been deleted!", {
                                icon: "success",
                            });
                            window.location = "/pegawai/"+peg_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });

        })
    </script>

@stop




