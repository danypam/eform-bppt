
@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">EDIT</h3>
                            </div>
                            <div class="panel-body">
                                <form action="/unit/{{$data_unit->id}}/update" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Kode Unit</label>
                                        <input value="{{$data_unit->kode_unit}}" name="kode_unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="nama jabatan">
                                        <small id="emailHelp" class="form-text text-muted">Kode Unit</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Nama Unit Kerja</label>
                                        <input value="{{$data_unit->nama_unit}}" name="nama_unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Unit Kerja">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Jabatan</label>
                                        <select name="alamat_id" class="form-control" id="exampleFormControlSelect1">
                                            @foreach($data_lokasi as $lok)
                                                <option value="{{$lok->id}}" @if($lok->id == $data_unit->alamat_id) selected @endif >{{$lok->alamat}}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Singkatan Unit</label>
                                            <input value="{{$data_unit->singkatan_unit}}" name="singkatan_unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan Unit">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Akun Kepala</label>
                                            <input value="{{$data_unit->akun_kepala}}" name="akun_kepala" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Akun Kepala">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Jabatan</label>
                                            <select name="jabatan_id" class="form-control" id="exampleFormControlSelect1">
                                                @foreach($data_jabatan as $jab)
                                                    <option value="{{$jab->id}}" @if($jab->id == $data_unit->jabatan_id) selected @endif >{{$jab->nama_jabatan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop





