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
                                <form action="/alamat/{{$data_alamat->id}}/update" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Address</label>
                                        <textarea  name="alamat" type="text" class="form-control" id="exampleFormControlInput1" placeholder="input address">{{$data_alamat->alamat}}</textarea>
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







