@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">ACTIVITIES</h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                $i=0;
                                ?>
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>USER</th>
                                        <th>DESCRIPTION</th>
                                        <th>ACCESSED</th>
                                        <th>MANAGED</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $a)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$a->name}}</td>
                                            <td>{{$a->text}}</td>
                                            <td>{{$a->ip_address}}</td>
                                            <td><span class="label label-default ">{{\Carbon\Carbon::parse($a->created_at)->diffForHumans()}}</span></td>
                                            <td>
                                                @can('log-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" log-id="{{$a->id}}">Delete</a>
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
            $('#datatable').DataTable();

            $('.delete').click(function () {
                var log_id = $(this).attr('log-id');
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
                            window.location = "/log/"+log_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        })
    </script>

@stop







