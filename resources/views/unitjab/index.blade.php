@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">INFORMASI UNIT JABATAN</h3>
                                <div class="right">
                                    @can('unitjab-create')
                                    <a href="#" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#exampleModal">Tambah Unit Jabatan</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>KODE UNIT JABATAN</th>
                                        <th>UNIT</th>
                                        <th>UNIT ATASAN 1</th>
                                        <th>UNIT ATASAN 2</th>
                                        <th>Abbreviation</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_unitjab as $a)
                                        <tr>
                                            <td>{{$a->kategori}}</td>
                                            <td>{{$a->id_unit_jabatan}}</td>
                                            <td>{{$a->unit_jabatan}}</td>
                                            <td>{{$a->unit_atas1}}</td>
                                            <td>{{$a->unit_atas2}}</td>
                                            <td>{{$a->singkat}}</td>
                                            <td>
                                                @can('unitjab-edit')
                                                <a href="/unitjab/{{$a->id_unit_jabatan}}/edit" class="btn btn-warning btn-sm">Ubah</a>
                                                @endcan
                                                @can('unitjab-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" unitjab-id="{{$a->id_unit_jabatan}}">Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA UNIT JABATAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/unitjab/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">KATEGORI</label>
                            <input name="kategori" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Kategori">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">KODE UNIT JABATAN</label>
                            <input name="id_unit_jabatan" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ID Unit Jabatan">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">UNIT</label>
                            <input name="unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Unit">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">UNIT ATAS PERTAMA</label>
                            <select name="kode_unitatas1" class="form-control" id="exampleFormControlSelect1">
                                <option>-pilih-</option>
                                @foreach($data_unitjab1 as $jab1)
                                    <option value="{{$jab1->id_unit_jabatan}}">{{$jab1->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">UNIT ATAS KEDUA</label>
                            <select name="kode_unitatas2" class="form-control" id="exampleFormControlSelect1">
                                <option>-pilih-</option>
                                @foreach($data_unitjab1 as $jab2)
                                    <option value="{{$jab2->id_unit_jabatan}}">{{$jab2->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">SINGKATAN</label>
                            <input name="singkat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                var unitjab_id = $(this).attr('unitjab-id');
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
                            window.location = "/unitjab/"+unitjab_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        })
    </script>

@stop






