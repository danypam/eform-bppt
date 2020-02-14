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
                                            <th>Employee ID Number</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>{{$task->nip}}</td>
                                                <td>{{$task->nama_lengkap}}</td>
                                                <td>{{$task->name}}</td>
                                                @if($task->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                @endif
                                                @if($task->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                @endif
                                                @if($task->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                @endif
                                                @if($task->status == 2 || $task->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                @endif
                                                @if($task->status == 4)
                                                    <td>C<span class="label label-success">COMPLETE</span></td>
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($task->created_at)}}</td>
                                                <td>
                                                    <a href="/forms/{{$task->form_id}}/submissions/{{$task->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                    @can('task-take')
                                                    @if($task->status == -1)
                                                        <a href="/submissions/{{$task->submission_id}}/approve" class="btn btn-primary btn-sm hidden">Take</a>
                                                    @else
                                                        <a href="/task/{{$task->submission_id}}/take" class="btn btn-primary btn-sm">Take</a>
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
                                            <th>Employee ID Number</th>
                                            <th>Name</th>
                                            <th>Form Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mytasks as $mytask)
                                            <tr>
                                                <td>{{$mytask->nip}}</td>
                                                <td>{{$mytask->nama_lengkap}}</td>
                                                <td>{{$mytask->name}}</td>
                                                @if($mytask->status == -1)
                                                    <td><span class="label label-danger">REJECTED</span></td>
                                                @endif
                                                @if($mytask->status == 0)
                                                    <td><span class="label label-primary">NEW</span></td>
                                                @endif
                                                @if($mytask->status == 1)
                                                    <td><span class="label label-warning">PENDING</span></td>
                                                @endif
                                                @if($mytask->status == 2 || $mytask->status == 3)
                                                    <td><span class="label label-primary">ON GOING</span></td>
                                                @endif
                                                @if($mytask->status == 4)
                                                    <td><span class="label label-success">COMPLETE</span></td>
                                                @endif
                                                <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($mytask->created_at)}}</td>
                                                <td>
                                                    <a href="/forms/{{$mytask->form_id}}/submissions/{{$mytask->submission_id}}" class="btn btn-warning btn-sm">View</a>
                                                    @can('task-take')
                                                        @if($mytask->status == -1)
                                                            <a href="/task/{{$mytask->submission_id}}/cancel" class="btn btn-danger btn-sm hidden">Cancel</a>
                                                            <a href="/task/{{$mytask->submission_id}}/complete" class="btn btn-danger btn-sm hidden">Cancel</a>
                                                        @else
                                                            <a href="/task/{{$mytask->submission_id}}/cancel" class="btn btn-danger btn-sm">Cancel</a>
                                                            <a href="/task/{{$mytask->submission_id}}/complete" class="btn btn-success btn-sm">Complete</a>

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
                                                    @if($complete->status == 2 || $complete->status == 3)
                                                        <td><span class="label label-primary">ON GOING</span></td>
                                                    @endif
                                                    @if($complete->status == 4)
                                                        <td><span class="label label-success">COMPLETE</span></td>
                                                    @endif
                                                    <td>{{\App\Http\Controllers\TimeController::time_elapsed_string($complete->created_at)}}</td>
                                                    <td>
                                                        <a href="/forms/{{$complete->form_id}}/submissions/{{$complete->submission_id}}" class="btn btn-warning btn-sm">View</a>
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
        });
    </script>
@stop



