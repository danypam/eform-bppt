    @extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Ubah</h3>
                            </div>
                            <div class="panel-body">
                                <form action="/pegawai/{{$pegawai->id}}/update" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">NIP 1</label>
                                        <input value="{{$pegawai->nip}}" name="nip" type="text" class="form-control" id="exampleFormControlInput1" placeholder="nip" pattern="[0-9]{9}"required>
                                        <small id="nip" class="form-text text-muted">9 Karakter Angka </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">NIP 2</label>
                                        <input value="{{$pegawai->nip18}}" name="nip18" type="text" class="form-control" id="exampleFormControlInput1" placeholder="nip"pattern="[0-9]{18}"required>
                                        <small id="nip18" class="form-text text-muted">18 Karakter Angka</small>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Nama Lengkap</label>
                                        <input value="{{$pegawai->nama_lengkap}}" name="nama_lengkap" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Lengkap"pattern="[A-Za-z\.,\s]{2,}"required>
                                        <small id="fullname" class="form-text text-muted">Hanya Berupa Huruf</small>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Nomor Handphone</label>
                                        <input value="{{$pegawai->no_hp}}" name="no_hp" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nomor HP"pattern="\d{6,13}$" required>
                                        <small id="hp" class="form-text text-muted">6-13 Karakter Angka </small>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email</label>
                                        <input value="{{$pegawai->email}}" name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email"pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"required>
                                        <small id="emailpeg" class="form-text text-muted"> Contoh: user@bppt.go.id</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Unit Kerja</label>
                                        <select name="unit_id" class="form-control selectpicker" data-live-search="true" id="exampleFormControlSelect1"required>
                                            <option selected disabled value="">-Pilih-</option>
                                        @foreach($data_unit as $unit)
                                                <option value="{{$unit->id}}" @if($unit->id == $pegawai->unit_id) selected @endif >{{$unit->nama_unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Unit Jabatan</label>
                                        <select name="unit_jabatan_id" class="form-control selectpicker" id="exampleFormControlSelect1" data-live-search="true"required>
                                            <option selected disabled value="">-Pilih-</option>
                                        @foreach($data_unjab as $unjab)
                                                <option value="{{$unjab->id_unit_jabatan}}" @if($unjab->id_unit_jabatan == $pegawai->unit_jabatan_id) selected @endif >{{$unjab->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Status</label>
                                        <select name="role" class="form-control selectpicker"  data-live-search="true"id="exampleFormControlSelect1"required>
                                            <option selected disabled value="">-Pilih-</option>
                                            <option value="AKTIF" @if($pegawai->status == 'AKTIF') selected @endif>AKTIF</option>
                                            <option value="NON AKTIF" @if($pegawai->status == 'NON AKTIF') selected @endif>NON AKTIF</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Foto</label>
                                        <input  name="foto" type="file" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-warning">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop





