@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">DEPARTMENT</h3>
                                <div class="right">
                                    @can('unit-create')
                                    <a href="#" class="btn btn-info btn-lg " data-toggle="modal" data-target="#exampleModal">Add New Department</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Department ID</th>
                                        <th>Department</th>
                                        <th>Address</th>
                                        <th>Abbreviation of Department</th>
                                        <th>Position</th>
                                        <th>Head Account</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_unit as $unit)
                                        <tr>
                                            <td>{{$unit->kode_unit}}</td>
                                            <td>{{$unit->nama_unit}}</td>
                                            <td>{{$unit->alamat}}</td>
                                            <td>{{$unit->singkatan_unit}}</td>
                                            <td>{{$unit->nama_jabatan}}</td>
                                            <td>{{$unit->akun_kepala}}</td>
                                            <td>{{$unit->created_at}}</td>
                                            <td>
                                                @can('unit-edit')
                                                <a href="/unit/{{$unit->id}}/edit" class="btn btn-warning btn-sm">Ubah</a>
                                                @endcan
                                                @can('unit-delete')
                                                <a href="#" class="btn btn-danger btn-sm delete" unit-id="{{$unit->id}}">Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/unit/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kode Unit</label>
                            <input name="kode_unit" type="text" class="form-control" id="exampleFormControlInput1" value="{{old('kode_unit')}}"placeholder="Kode Unit"pattern="[0-9]{2,}"required>
                            <small id="kodeunit" class="form-text text-muted">Numeric Characters Only. At Least 2 Characters </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Jabatan</label>
                            <input name="nama_unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Jabatan"pattern="[A-Za-z\.,\s]{2,}"required>
                            <small id="namaunit" class="form-text text-muted">Letters Only. At Least 3 Characters</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Address</label>
                            <select name="alamat_id" class="form-control selectpicker"  data-live-search="true" id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-select-</option>
                                @foreach($data_alamat as $al)
                                    <option value="{{$al->id}}">{{$al->alamat}}</option>
                                @endforeach
                            </select>
                            <small id="unit" class="form-text text-muted">Please, Choose One! </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Singkatan Unit Kerja</label>
                            <input name="singkatan_unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan Unit Kerja"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Akun Kepala</label>
                            <input name="akun_kepala" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Akun Kepala"required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jabatan</label>
                            <select name="jabatan_id" class="form-control selectpicker"  data-live-search="true" id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-select-</option>
                                @foreach($data_jabatan as $jab)
                                    <option value="{{$jab->id}}">{{$jab->nama_jabatan}}</option>
                                @endforeach
                            </select>
                            <small id="unit" class="form-text text-muted">Please, Choose One! </small>
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
            $('#datatable').DataTable({});

            $('.delete').click(function () {
                var unit_id = $(this).attr('unit-id');
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
                            window.location = "/unit/"+unit_id+"/delete";
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        })
    </script>

@stop




