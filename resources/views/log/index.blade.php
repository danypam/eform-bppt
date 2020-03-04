@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Aktifitas User</h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                $i=0;
                                ?>
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Deskripsi</th>
                                        <th>URL</th>
                                        <th>Method</th>
                                        <th>IP Address</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $a)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$a->name}}</td>
                                            <td>{{$a->subject}}</td>
                                            <td>{{$a->url}}</td>
                                            <td><span class="label label-primary">{{$a->method}}</span></td>
                                            <td>{{$a->ip}}</td>
                                            <td><span class="label label-default ">{{\Carbon\Carbon::parse($a->created_at)->diffForHumans()}}</span></td>
                                            <td>
                                                @can('log-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" log-id="{{$a->id}}">Hapus</a>
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

            $('#datatable').on( "click",'.delete', function() {
                var log_id = $(this).attr('log-id');
                swal({
                    title: "Apakah anda yakin?",
                    text: "Jika data dihapus, data tidak bisa kembali!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Poof! Data telah dihapus!", {
                                icon: "success",
                            });
                            window.location = "/log/"+log_id+"/delete";
                        } else {
                            swal("Data batal dihapus!");
                        }
                    });
            });
        })
    </script>

@stop







