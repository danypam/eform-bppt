@extends('layouts.master')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($forms as $form)
                                <div class="col-md-3">
                                    <!-- komponen panel di sini  -->
                                    <div class="panel panel-default card-form">

                                        <div class="panel-heading post-thumb-form ">
                                            <img class="img img-responsive" src="https://www.kindpng.com/picc/m/33-337870_cairns-kangarooms-booking-form-license-round-icon-hd.png"/>
                                        </div>

                                        <div class="panel-body post-body-form bg-white">
                                            <a class="label label-default btn-danger" href="#">Form</a>
                                            <h3 class="post-title-form">
                                                <a href="/form/{{$form->identifier}}">{{$form->name}}</a>
                                            </h3>

                                            <div class="post-author-form">
                                                <img class="author-photo-form" height="32" src="https://upload.wikimedia.org/wikipedia/commons/5/5d/Logo_BPPT.png" width="32">
                                                <a href="#">BPPT</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
