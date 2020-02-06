
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
                                <form action="/unitjab/{{$data_unitjab->id_unit_jabatan}}/update" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">KATEGORI</label>
                                        <input value="{{$data_unitjab->kategori}}" name="kategori" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Kategori">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">KODE UNIT JABATAN</label>
                                        <input value="{{$data_unitjab->id_unit_jabatan}}" name="id_unit_jabatan" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ID Unit Jabatan">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">UNIT</label>
                                        <input value="{{$data_unitjab->unit}}" name="unit" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Unit">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">UNIT ATASAN 1</label>
                                        <select name="kode_unitatas1" class="form-control" id="exampleFormControlSelect1">
                                            @foreach($data_unitjab1 as $jab)
                                                <option value="{{$jab->id_unit_jabatan}}" @if($jab->id_unit_jabatan == $data_unitjab->kode_unitatas1) selected @endif >{{$jab->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">UNIT ATASAN 2</label>
                                        <select name="kode_unitatas2" class="form-control" id="exampleFormControlSelect1">
                                            @foreach($data_unitjab1 as $jab)
                                                <option value="{{$jab->id_unit_jabatan}}" @if($jab->id_unit_jabatan == $data_unitjab->kode_unitatas2) selected @endif >{{$jab->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">SINGKATAN</label>
                                        <input value="{{$data_unitjab->singkat}}" name="singkat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Singkatan">
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






