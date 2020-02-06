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
                                        <input value="{{$jabatan->nama_jabatan}}" name="nama_jabatan" type="text" class="form-control" id="exampleFormControlInput1" placeholder="nama jabatan" pattern="^[A-Z\s]{0,}$" value="{{old('nama_jabatan')}}">
                                        <small id="emailHelp" class="form-text text-muted"> Nama Jabatan Harus Kapital </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Eselon</label>
                                        <input value="{{$jabatan->eselon}}" name="eselon" type="text" class="form-control" id="exampleFormControlInput1" placeholder="eselon" pattern="^[A-Z]+\.[a-z]{0,5}$" value="{{old('eselon')}}">
                                        <small id="eselon" class="form-text text-muted"> Format : huruf.huruf Misal: II.a </small>
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






