
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
                                <form action="/unitjab/{{$data_unitjab->id_unit_jabatan}}/update" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Kategori</label>
                                        <input value="{{$data_unitjab->kategori}}" name="kategori" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Kategori"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Kode Unit Jabatan</label>
                                        <input value="{{$data_unitjab->id_unit_jabatan}}" name="id_unit_jabatan" type="text" class="form-control" id="exampleFormControlInput1"pattern="[0-9]{2,}" placeholder="Kode Unit Jabatan"required>
                                        <small id="kodeunit" class="form-text text-muted">Hanya Huruf. Minimal 2 digit. </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Unit Kerja</label>
                                        <input value="{{$data_unitjab->unit}}" name="unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Unit"required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Unit Atasan Pertama</label>
                                        <select name="kode_unitatas1" class="form-control selectpicker"  data-live-search="true"id="exampleFormControlSelect1"required>
                                            <option selected disabled value="">-Pilih-</option>
                                        @foreach($data_unitjab1 as $jab)
                                                <option value="{{$jab->id_unit_jabatan}}" @if($jab->id_unit_jabatan == $data_unitjab->kode_unitatas1) selected @endif >{{$jab->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Unit Atasan Kedua</label>
                                        <select name="kode_unitatas2" class="form-control selectpicker"  data-live-search="true" id="exampleFormControlSelect1"required>
                                            <option selected disabled value="">-Pilih-</option>
                                        @foreach($data_unitjab1 as $jab)
                                                <option value="{{$jab->id_unit_jabatan}}" @if($jab->id_unit_jabatan == $data_unitjab->kode_unitatas2) selected @endif >{{$jab->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Singkatan</label>
                                        <input value="{{$data_unitjab->singkat}}" name="singkat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan"required>
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






