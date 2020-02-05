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
                                    <a href="#" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#exampleModal" >Add Employee</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>NAME</th>
                                        <th>PHONE NUMBER</th>
                                        <th>EMAIL</th>
                                        <th>UNIT KERJA</th>
                                        <th>JABATAN</th>
                                        <th>UNIT JABATAN</th>
                                        <th>ATASAN</th>
                                        <th>JABATAN</th>
                                        <th>UNIT JABATAN</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
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
                                                        <b><span  class="dropdown-item " >NIP 1 : {{$peg->nip}}</span><br>
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
                                            <td>{{$peg->nama_atas}}</td>
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
                            <input name="nip" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">NIP 2</label>
                            <input name="nip18" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 2">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input name="nama_lengkap" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone Number</label>
                            <input name="no_hp" type="text" class="form-control" id="exampleFormControlInput1" placeholder="No Telp">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Kerja</label>
                            <select name="unit_id" class="form-control" id="exampleFormControlSelect1">
                                <option value="">-select-</option>
                                @foreach($data_unit as $unit)
                                    <option value="{{$unit->id}}">{{$unit->nama_unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Jabatan</label>
                            <select name="jabatan_id" class="form-control" id="exampleFormControlSelect1">
                                <option value="">-select-</option>
                                @foreach($data_jabatan as $jab)
                                    <option value="{{$jab->id}}">{{$jab->nama_jabatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Unit Jabatan</label>
                            <select name="unit_jabatan_id" class="form-control selectpicker" id="exampleFormControlSelect1" data-live-search="true">
                                <option value="">-select-</option>
                                @foreach($data_unitjab as $unjab)
                                    <option value="{{$unjab->id_unit_jabatan}}">{{$unjab->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Nama Atasan</label>
                            <select name="nip_atas" class="form-control" id="exampleFormControlSelect1">
                                <option value="">-select-</option>
                                @foreach($pegawai as $p)
                                    <option value="{{$p->id}}">{{$p->nama_lengkap}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Role</label>
                            <select name="role" class="form-control" id="exampleFormControlSelect1">
                                <option value="">-select-</option>
                                @foreach($data_role as $rol)
                                    <option value="{{$rol->name}}">{{$rol->name}}</option>
                                @endforeach
                            </select>
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



