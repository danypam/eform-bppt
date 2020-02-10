@extends('formbuilder::layout')

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
                                        <h1 class="card-title">{{ $pageTitle }}</h1>
                                    </div>

                                    <form action="{{ route('formbuilder::form.submit', $form->identifier) }}" method="POST" id="submitForm" enctype="multipart/form-data">
                                        @csrf

                                        <div class="card-body" style="font-weight: normal">
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
    <style>
        .form-control:focus {
            /*border-color: #ff80ff;*/
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 1) inset, 0px 0px 8px rgba(255, 100, 255, 0.5);
        }
    </style>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
<script type="text/javascript">
    window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
</script>
<script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
