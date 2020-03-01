@extends('formbuilder::layout')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            @auth
                                                <a href="{{ route('formbuilder::my-submissions.index') }}" class="btn btn-primary btn-sm float-md-right">
                                                    <i class="fa fa-th-list"></i> Kembali
                                                </a>
                                            @endauth
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <h3 class="text-center text-success">
                                            Permohonan <strong>{{ $form->name }}</strong> berhasil diajukan.
                                        </h3>
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('home') }}" class="btn btn-primary confirm-form">
                                            <i class="fa fa-home"></i> Return Home
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
