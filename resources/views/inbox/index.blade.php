@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">INBOX</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Form Type</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inboxs as $inbox)
                                        <tr>
                                            <td>{{$inbox->email}}</td>
                                            <td>{{$inbox->nama_lengkap}}</td>
                                            <td>{{$inbox->name}}</td>
                                            @if($inbox->status == -1)
                                            <td><span class="label label-danger">REJECTED</span></td>
                                            @endif
                                            @if($inbox->status == 0)
                                                <td><span class="label label-primary">NEW</span></td>
                                            @endif
                                            @if($inbox->status == 1)
                                                <td><span class="label label-warning">PENDING</span></td>
                                            @endif
                                            @if($inbox->status == 2 || $inbox->status == 3)
                                            <td><span class="label label-primary">ON GOING</span></td>
                                            @endif
                                            @if($inbox->status == 4)
                                                <td>C<span class="label label-success">COMPLETE</span></td>
                                            @endif
                                            <td>{{$inbox->created_at}}</td>
                                            <td>
                                                <a href="/forms/{{$inbox->form_id}}/submissions/{{$inbox->submission_id}}" class="btn btn-warning btn-sm">View</a>

                                                @if($inbox->status == -1)
                                                    <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm hidden">Approve</a>
                                                    <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm hidden">Reject</a>
                                                    @else
                                                    <a href="/submissions/{{$inbox->submission_id}}/approve" class="btn btn-primary btn-sm">Approve</a>
                                                    <a href="/submissions/{{$inbox->submission_id}}/reject" class="btn btn-danger btn-sm">Reject</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

{{--                                            <td><span class="label label-success">{{$peg->status}}</span></td>--}}
{{--                                            --}}{{--                                            @if($peg->status == '1')--}}
{{--                                            --}}{{--                                            {--}}
{{--                                            --}}{{--                                                <td>Aktif</td>--}}
{{--                                            --}}{{--                                            }@else{--}}
{{--                                            --}}{{--                                                <td>Tidak Akif</td>--}}
{{--                                            --}}{{--                                            }--}}
{{--                                            <td>--}}
{{--                                                @can('pegawai-edit')--}}
{{--                                                    <a href="/pegawai/{{$peg->id}}/edit" class="btn btn-warning btn-sm">Ubah</a>--}}
{{--                                                @endcan--}}
{{--                                                @can('pegawai-delete')--}}
{{--                                                    <a href="#" class="btn btn-danger btn-sm delete" pegawai-id="{{$peg->id}}">Hapus</a>--}}
{{--                                                @endcan--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
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
{{--    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA JABATAN</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <form action="/pegawai/create" method="POST">--}}
{{--                        {{csrf_field()}}--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput1">NIP 1</label>--}}
{{--                            <input name="nip" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 1">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput1">NIP 2</label>--}}
{{--                            <input name="nip18" type="text" class="form-control" id="exampleFormControlInput1" placeholder="NIP 2">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput1">Nama Lengkap</label>--}}
{{--                            <input name="nama_lengkap" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Lengkap">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput1">No Telp</label>--}}
{{--                            <input name="no_hp" type="text" class="form-control" id="exampleFormControlInput1" placeholder="No Telp">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput1">Email</label>--}}
{{--                            <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlSelect1">Unit Kerja</label>--}}
{{--                            <select name="unit_id" class="form-control" id="exampleFormControlSelect1">--}}
{{--                                <option value="">-pilih-</option>--}}
{{--                                @foreach($data_unit as $unit)--}}
{{--                                    <option value="{{$unit->id}}">{{$unit->nama_unit}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlSelect1">Jabatan</label>--}}
{{--                            <select name="jabatan_id" class="form-control" id="exampleFormControlSelect1">--}}
{{--                                <option value="">-pilih-</option>--}}
{{--                                @foreach($data_jabatan as $jab)--}}
{{--                                    <option value="{{$jab->id}}">{{$jab->nama_jabatan}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlSelect1">Unit Jabatan</label>--}}
{{--                            <select name="unit_jabatan_id" class="form-control" id="exampleFormControlSelect1">--}}
{{--                                <option value="">-pilih-</option>--}}
{{--                                @foreach($data_unitjab as $unjab)--}}
{{--                                    <option value="{{$unjab->id_unit_jabatan}}">{{$unjab->unit}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlSelect1">Nama Atasan</label>--}}
{{--                            <select name="nip_atas" class="form-control" id="exampleFormControlSelect1">--}}
{{--                                <option value="">-pilih-</option>--}}
{{--                                @foreach($pegawai as $p)--}}
{{--                                    <option value="{{$p->id}}">{{$p->nama_lengkap}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlSelect1">Role</label>--}}
{{--                            <select name="role" class="form-control" id="exampleFormControlSelect1">--}}
{{--                                <option value="">-pilih-</option>--}}
{{--                                @foreach($data_role as $rol)--}}
{{--                                    <option value="{{$rol->name}}">{{$rol->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    <button type="submit" class="btn btn-primary">Simpan</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@stop
@section('footer')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                scrollY:     300,
                scroller:    true
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



