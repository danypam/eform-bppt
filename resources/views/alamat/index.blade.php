@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">LOCATIONS</h3>
                                <div class="right">
                                    @can('alamat-create')
                                        <a href="#" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#exampleModal">Add New Location</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    $i=0;
                                ?>
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>NUMBER</th>
                                        <th>ADDRESS</th>
                                        <th>MANAGED</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_alamat as $al)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$al->alamat}}</td>
                                            <td>{{$al->created_at}}</td>
                                            <td>
                                                @can('alamat-edit')
                                                    <a href="/alamat/{{$al->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                                @endcan
                                                @can('alamat-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" alamat-id="{{$al->id}}">Delete</a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/alamat/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Address</label>
                            <textarea name="alamat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="input address"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
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
            $('#datatable').DataTable();

            $('.delete').click(function () {
                var al_id = $(this).attr('alamat-id');
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
                            window.location = "/alamat/"+al_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        })
    </script>

@stop




