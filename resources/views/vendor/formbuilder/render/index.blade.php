@extends('formbuilder::layout')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
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
                                            <div id="fb-render"></div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary confirm-form" data-form="submitForm" data-message="Submit your entry for '{{ $form->name }}'?">
                                                <i class="fa fa-submit"></i> Submit Form
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"/>
@endsection
@push(config('formbuilder.layout_js_stack', 'scripts'))

<script>
    window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    console.log(window._form_builder_content);
</script>
<script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>

@endpush
