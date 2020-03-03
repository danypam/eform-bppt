@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Data Unit Jabatan</h3>
                                <div class="right">
                                    @can('unitjab-create')
                                    <a href="#" class="btn btn-info btn-lg " data-toggle="modal" data-target="#exampleModal">Tambah Unit Jabatan</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Kode</th>
                                        <th>Unit Jabatan</th>
                                        <th>Unit Atasan 1</th>
                                        <th>Unit Atasan 2</th>
                                        <th>Singkatan Unit</th>
                                        <th>Aksi</th>
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
                                                <a href="/unitjab/{{$a->id_unit_jabatan}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                                @endcan
                                                @can('unitjab-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" unitjab-id="{{$a->id_unit_jabatan}}">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Unit Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/unitjab/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kategori</label>
                            <input name="kategori" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Kategori"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kode Unit Jabatan</label>
                            <input name="id_unit_jabatan" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Kode Unit Jabatan"pattern="[0-9]{2,}"required>
                            <small id="kodeunit" class="form-text text-muted">Hanya Huruf. Minimal 2 karakter </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Unit Kerja</label>
                            <input name="unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Unit Kerja"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Atasan Pertama</label>
                            <select name="kode_unitatas1" class="form-control selectpicker"  data-live-search="true" id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-Pilih-</option>
                                @foreach($data_unitjab1 as $jab1)
                                    <option value="{{$jab1->id_unit_jabatan}}">{{$jab1->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Atasan Kedua</label>
                            <select name="kode_unitatas2" class="form-control selectpicker"  data-live-search="true" id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-Pilih-</option>
                                @foreach($data_unitjab1 as $jab2)
                                    <option value="{{$jab2->id_unit_jabatan}}">{{$jab2->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Singkatan</label>
                            <input name="singkat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan"required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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

            $('#datatable').on( "click",'.delete', function() {
                var unitjab_id = $(this).attr('unitjab-id');
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
                            window.location = "/unitjab/"+unitjab_id+"/delete";
                        } else {
                            swal("Data batal dihapus!");
                        }
                    });
            });
        })
    </script>

@stop






