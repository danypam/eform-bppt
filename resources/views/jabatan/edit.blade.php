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
                                <form action="/jabatan/{{$jabatan->id}}/update" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Nama Jabatan</label>
                                        <input value="{{$jabatan->nama_jabatan}}" name="nama_jabatan" type="text" class="form-control" id="exampleFormControlInput1" placeholder="nama jabatan">
                                        <small id="emailHelp" class="form-text text-muted">nama jabatan kapital</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Eselon</label>
                                        <input value="{{$jabatan->eselon}}" name="eselon" type="text" class="form-control" id="exampleFormControlInput1" placeholder="eselon">
                                    </div>
                                    <button type="submit" class="btn btn-warning">Ubah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop






