@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                               <h3 style="margin-bottom: 10px" class="panel-title">TASKS</h3>
                                <ul class="nav nav-tabs">
                                    <li  class="active" id="tab-waiting-list"><a href="#waiting-list">Waiting List</a></li>
                                    <li id="tab-my-task"><a href="#my-task">My Task</a></li>
                                    <li id="tab-complete"><a href="#complete">Complete</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
{{--                                waiting list--}}
                                <div id="waiting-list" class="">
                                    <table class="table table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>Form ID</th>
                                            <th>Employee ID Number</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>{{$task->submission_id}}</td>
                                                <td>{{$task->nip}}</td>
                                                <td>{{$task->nama_lengkap}}</td>
                                                <td>{{$task->name}}</td>
                                                @if($task->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $task->rejected)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$task->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($task->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                    <td><a href="#" class="label label-default view" data-ket="{{$task->keterangan}}">LIHAT KETERANGAN</a></td>
                                                @endif
                                                @if($task->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $task->mengetahui)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$task->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($task->status == 2)
                                                    <td><span class="label label-primary">WAIT FOR PIC</span></td>
                                                @endif
                                                @if($task->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $task->menyetujui)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$task->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($task->status == 4)
                                                    <td><span class="label label-success">COMPLETE</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $task->pic)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$task->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($task->created_at)}}</td>
                                                <td>
                                                    <a href="/task/{{$task->form_id}}/submissions/{{$task->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                    @can('task-take')
                                                    @if($task->status == -1)
                                                        <a href="/submissions/{{$task->submission_id}}/approve" class="btn btn-primary btn-sm hidden">Take</a>
                                                    @else
                                                        <a href="#" class="btn btn-primary btn-sm take" take-id="{{$task->submission_id}}">Take</a>
                                                    @endif
                                                     @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
{{--                                my task--}}
                                <div id="my-task" class="hidden">
                                    <table class="table table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>Form ID</th>
                                            <th>Employee ID Number</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mytasks as $mytask)
                                            <tr>
                                                <td>{{$mytask->submission_id}}</td>
                                                <td>{{$mytask->nip}}</td>
                                                <td>{{$mytask->nama_lengkap}}</td>
                                                <td>{{$mytask->name}}</td>
                                                @if($mytask->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $mytask->rejected)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$mytask->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($mytask->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                    <td><a href="#" class="label label-default view" data-ket="{{$mytask->keterangan}}">LIHAT KETERANGAN</a></td>
                                                @endif
                                                @if($mytask->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $mytask->mengetahui)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$mytask->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($mytask->status == 2)
                                                    <td><span class="label label-primary">WAIT FOR PIC</span></td>
                                                @endif
                                                @if($mytask->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                    @foreach($pegawai as $p)
                                                    @if($p->id == $mytask->menyetujui)
                                                        <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$mytask->keterangan}}">LIHAT KETERANGAN</a></td>
                                                    @endif
                                                    @endforeach
                                                @endif
                                                @if($mytask->status == 4)
                                                    <td><span class="label label-success">COMPLETE</span></td>
                                                    @foreach($pegawai as $p)
                                                        @if($p->id == $mytask->pic)
                                                            <td><a href="#" class="label label-default view" data-status="{{$p->nama_lengkap}}" data-ket="{{$mytask->keterangan}}">LIHAT KETERANGAN</a></td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($mytask->created_at)}}</td>
                                                <td>
                                                    <a href="/task/{{$mytask->form_id}}/submissions/{{$mytask->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                    @can('task-take')
                                                        @if($mytask->status == -1)
                                                            <a href="/task/{{$mytask->submission_id}}/cancel" class="btn btn-danger btn-sm hidden">Cancel</a>
                                                            <a href="/task/{{$mytask->submission_id}}/complete" class="btn btn-danger btn-sm hidden">Cancel</a>
                                                        @else
                                                            <a href="/task/{{$mytask->submission_id}}/cancel" class="btn btn-danger btn-sm">Cancel</a>
                                                            <a href="#" data-toggle="modal" data-target="#comp" data-id="{{$mytask->submission_id}}" data-ket="{{$mytask->keterangan}}" class="btn btn-success btn-sm">Complete</a>
                                                        @endif
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
{{--                                    complete--}}
                                    <div id="complete" class="hidden">
                                        <table class="table table-hover datatable">
                                            <thead>
                                            <tr>
                                                <th>Form ID</th>
                                                <th>Employee ID Number</th>
                                                <th>Name</th>
                                                <th>Form Type</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($completes as $complete)
                                                <tr>
                                                    <td>{{$complete->submission_id}}</td>
                                                    <td>{{$complete->nip}}</td>
                                                    <td>{{$complete->nama_lengkap}}</td>
                                                    <td>{{$complete->name}}</td>
                                                    @if($complete->status == -1)
                                                        <td><span class="label label-danger">REJECTED</span></td>
                                                    @endif
                                                    @if($complete->status == 0)
                                                        <td><span class="label label-primary">NEW</span></td>
                                                    @endif
                                                    @if($complete->status == 1)
                                                        <td><span class="label label-warning">PENDING</span></td>
                                                    @endif
                                                    @if($complete->status == 2)
                                                        <td><span class="label label-primary">WAIT FOR PIC</span></td>
                                                    @endif
                                                    @if($complete->status == 3)
                                                        <td><span class="label label-primary">ON GOING</span></td>
                                                    @endif
                                                    @if($complete->status == 4)
                                                        <td><span class="label label-success">COMPLETE</span></td>
                                                    @endif
                                                    <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($complete->created_at)}}</td>
                                                    <td>
                                                        <a href="/task/{{$complete->form_id}}/submissions/{{$complete->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                        @can('task-take')
                                                            @if($complete->status == -1)
                                                                <a href="/task/{{$complete->submission_id}}/cancel" class="btn btn-danger btn-sm hidden">Cancel</a>
                                                            @else
                                                                    <a href="/task/{{$complete->submission_id}}/cancel" class="btn btn-danger btn-sm">Cancel</a>

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
    </div>

    <div class="modal fade" id="comp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/task/complete" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="submission_id" id="id" value="" >
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Keterangan</label>
                            <textarea name="keterangan" type="text" class="form-control" placeholder="Silakan Isi Keterangan Jika Diperlukan"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Complete</button>
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
            {{--    togle tab--}}
            $('.datatable').DataTable();
            $( '#tab-my-task' ).on('click', function() {
                $( "#waiting-list" ).addClass( "hidden" );
                $( "#complete" ).addClass( "hidden");
                $( "#my-task" ).removeClass( "hidden");

                $( "#tab-my-task" ).addClass( "active");
                $( "#tab-waiting-list" ).removeClass( "active");
                $( "#tab-complete" ).removeClass( "active");
            });
            $( "#tab-waiting-list" ).on('click', function() {
                $( "#waiting-list" ).removeClass( "hidden" );
                $( "#my-task" ).addClass( "hidden" );
                $( "#complete" ).addClass( "hidden" );

                $( "#tab-waiting-list" ).addClass( "active");
                $( "#tab-my-task" ).removeClass( "active");
                $( "#tab-complete").removeClass( "active");
            });
            $( "#tab-complete" ).on('click', function() {
                $( "#complete" ).removeClass( "hidden" );
                $( "#my-task" ).addClass( "hidden" );
                $( "#waiting-list" ).addClass( "hidden" );

                $( "#tab-complete" ).addClass( "active");
                $( "#tab-my-task" ).removeClass( "active");
                $( "#tab-waiting-list" ).removeClass( "active");
            });
            $('#comp').on('show.bs.modal',function (event) {

                var button = $(event.relatedTarget)
                var id = button.data('id')
                var keterangan = button.data('ket')
                var modal = $(this)

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #ket').val(keterangan);
            });
            $('.view').click(function () {
                var span = document.createElement("span");
                span.innerHTML  ="<b>Ditambahkan Terakhir Oleh :<b><br>" +$(this).attr('data-status');
                swal({
                    title: "KETERANGAN",
                    content: span,
                    html: true,
                    text: $(this).attr('data-ket')
                });
            });
            $('.take').click(function () {
                var take_id = $(this).attr('take-id');
                swal({
                    title: "Are you sure?",
                    text: "Sebelum mengambil pekejaan, Pastikan anda melihat keterangan yang terlampir ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Good Luck!", "Kamu berhasil mengambil pekerjaan!", "success", {
                                button: "OK",
                            });
                            window.location = "/task/"+take_id+"/take";
                        } else {
                            swal("Anda Ragu dalam mengambil pekerjaan");
                        }
                    });
            });
        });
    </script>
@stop



