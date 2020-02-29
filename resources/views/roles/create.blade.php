@extends('layouts.master')

@section('content')


    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">TAMBAH ROLE</h3>
                                <div class="right">
                                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> Kembali</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Ooops!</strong> Data yang dimasukkan tidak sesuai !<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Nama Role:</strong>
                                            {!! Form::text('name', null, array('placeholder' => 'Nama','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Permission:</strong>
                                            <br/>
                                            @foreach($permission as $value)
                                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                                <br/>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

