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

                                    <h3 class="panel-title">Ubah Password</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="/auth/ubahpass/update" method="POST">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password Sebelumnya</label>
                                            <input  name="password_lama" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password Sebelumnya" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password Baru</label>
                                            <input name="password_baru" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password Baru" required>
                                            <small id="newpass" class="form-text text-muted">Gunakan Password Baru</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Konfirmasi Password Baru</label>
                                            <input name="password_confirm" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Konfirmasi Password Baru" required>
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
    </div>
    </div>
@stop

