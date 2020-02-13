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

                                    <h3 class="panel-title">Change Password</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="/auth/ubahpass/update" method="POST">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Recent Password</label>
                                            <input  name="password_lama" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Recent Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New Password</label>
                                            <input name="password_baru" type="password" class="form-control" id="exampleFormControlInput1" placeholder="New Password"required>
                                            <small id="newpass" class="form-text text-muted">Please Enter The Different Password</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Confirm Password</label>
                                            <input name="password_confirm" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Confirm Password"required>
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

