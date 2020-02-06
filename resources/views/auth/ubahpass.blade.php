@extends('layouts.master')

@section('content')
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel">
                                <div class="panel-heading">

                                    <h3 class="panel-title">CHANGE PASSWORD</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="/auth/ubahpass/update" method="POST">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">RECENT PASSWORD</label>
                                            <input  name="password_lama" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Recent Password ">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">NEW PASSWORD</label>
                                            <input name="password_baru" type="password" class="form-control" id="exampleFormControlInput1" placeholder="New Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">CONFIRM PASSWORD</label>
                                            <input name="password_confirm" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Confirm Password">
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
    </div>
    </div>
@stop

