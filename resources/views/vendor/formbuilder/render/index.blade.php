@extends('formbuilder::layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-render.min.js') }}" defer></script>
@endsection
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <h1 class="card-title">{{ $pageTitle}}</h1>
                                    </div>

                                    <form action="{{ route('formbuilder::form.submit', $form->identifier) }}" method="POST" id="submitForm" enctype="multipart/form-data">
                                        @csrf


                                        <div class="card-body">
                                            <input type="datetime-local" class="form-control" name="nana" id="nana1">
                                            <div id="fb-render"></div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary confirm-form" data-form="submitForm" data-message="Kirim permohonan '{{ $form->name }}'?">
                                                <i class="fa fa-submit"></i> Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
@push(config('formbuilder.layout_js_stack', 'scripts'))

<script>
    window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    console.log(window._form_builder_content);
</script>
<script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>

@endpush
