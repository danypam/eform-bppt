@extends('layouts.master')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                  <div class="list-group">
                                      <a  class="list-group-item active">
                                         Formulir
                                      </a>
                                      @foreach($forms as $form)
                                    <a type="button" class="list-group-item" href="/form/{{$form->identifier}}">{{$form->name}}</a>
                                      @endforeach
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop
