@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">EMPLOYEES INFORMATION</h3>
                                <div class="right">
                                    @can('pegawai-create')
                                    <a href="#" class="btn btn-info btn-lg " data-toggle="modal" data-target="#exampleModal" >Add Employee</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Employee ID Number</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Unit Jabatan</th>
                                        <th>Position</th>
                                        <th>Unit Jabatan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_pegawai as $peg)
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        NIP
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <span  class="dropdown-item " >NIP 1 : {{$peg->nip}}</span><br>
                                                            <span class="dropdown-item" >NIP 2 : {{$peg->nip18}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="/pegawai/{{$peg->id}}/profile">{{$peg->nama_lengkap}}</a></td>
                                            <td>{{$peg->no_hp}}</td>
                                            <td>{{$peg->email}}</td>
                                            <td>{{$peg->nama_unit}}</td>
                                            <td>{{$peg->nama_jabatan}}</td>
                                            <td>{{$peg->unit}}</td>
                                            @foreach($data_jabatan as $peg1)
                                                @if($peg1->id == $peg->idjab)
                                                    <td>{{$peg1->nama_jabatan}}</td>
                                                @endif
                                            @endforeach
                                            @foreach($data_unitjab as $unjab1)
                                                @if($unjab1->id_unit_jabatan == $peg->unjab_atas)
                                                    <td>{{$unjab1->unit}}</td>
                                                @endif
                                            @endforeach

                                            <td><span class="label label-success">{{$peg->status}}</span></td>
                                            {{--                                            @if($peg->status == '1')--}}
                                            {{--                                            {--}}
                                            {{--                                                <td>Aktif</td>--}}
                                            {{--                                            }@else{--}}
                                            {{--                                                <td>Tidak Akif</td>--}}
                                            {{--                                            }--}}
                                            <td>
                                                @can('pegawai-edit')
                                                <a href="/pegawai/{{$peg->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                                @endcan
                                                @can('pegawai-delete')
                                                    <a href="#" class="btn btn-danger btn-sm delete" pegawai-id="{{$peg->id}}">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/pegawai/create" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIP 1</label>
                            <input name="nip" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 1"value="{{old('nip')}}"pattern="[0-9]{9}"required>
                            <small id="nip" class="form-text text-muted">9 Numeric Characters Only </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIP 2</label>
                            <input name="nip18" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 2"value="{{old('nip18')}}"pattern="[0-9]{18}"required>
                            <small id="nip18" class="form-text text-muted">18 Numeric Characters Only </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Full Name</label>
                            <input name="nama_lengkap" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Lengkap"value="{{old('nama_lengkap')}}"pattern="[A-Za-z\.,\s]{2,}"required>
                            <small id="fullname" class="form-text text-muted">Letters Only</small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone Number</label>
                            <input name="no_hp" type="tel" class="form-control" id="exampleFormControlInput1" placeholder="Nomor HP"pattern="\d{6,13}$" value="{{old('no_hp')}}"required>
                            <small id="hp" class="form-text text-muted">6-13 Numeric Characters Only </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="example@example.com"value="{{old('email')}}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"required>
                            <small id="emailpeg" class="form-text text-muted"> Format Email: local-part@domain ex: smith@example.com </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Kerja</label>
                            <select name="unit_id" class="form-control selectpicker"  data-live-search="true"id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-select-</option>
                                @foreach($data_unit as $unit)
                                    <option value="{{$unit->id}}">{{$unit->nama_unit}}</option>
                                @endforeach
                            </select>
                            <small id="unit" class="form-text text-muted">Please, Choose One! </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jabatan</label>
                            <select name="jabatan_id" class="form-control selectpicker"  data-live-search="true"id="exampleFormControlSelect1" >
                                <option value="">-select-</option>
                                @foreach($data_jabatan as $jab)
                                    <option value="{{$jab->id}}">{{$jab->nama_jabatan}}</option>
                                @endforeach
                            </select>
                            <small id="jab" class="form-text text-muted">Please, Choose One! </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Jabatan</label>
                            <select name="unit_jabatan_id" class="form-control selectpicker" id="exampleFormControlSelect1" data-live-search="true"required>
                                <option selected disabled value="">-select-</option>
                                @foreach($data_unitjab as $unjab)
                                    <option value="{{$unjab->id_unit_jabatan}}">{{$unjab->unit}}</option>
                                @endforeach
                            </select>
                            <small id="unjab" class="form-text text-muted">Please, Choose One! </small>

                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Role</label>
                            <select name="role" class="form-control selectpicker"  data-live-search="true"id="exampleFormControlSelect1"required>
                                <option selected disabled value="">-select-</option>
                                @foreach($data_role as $rol)
                                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                                @endforeach
                            </select>
                            <small id="role" class="form-text text-muted">Please, Choose One! </small>

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
            $('#datatable').DataTable({
                scroller:    true,
                scrollX:     300
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



