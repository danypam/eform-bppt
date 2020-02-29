@extends('formbuilder::layout')

@section('content')
    <div class="">
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card rounded-0">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Formulir '{{ $form->name }}'</h3>

                                        <div class="btn-toolbar float-md-right" role="toolbar">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-primary float-md-right btn-sm">
                                                    <i class="fa fa-arrow-left"></i>
                                                </a>
                                                <a href="{{ route('formbuilder::forms.edit', $form) }}" class="btn btn-primary float-md-right btn-sm">
                                                    <i class="fa fa-edit"></i> Ubah
                                                </a>
                                            </div>
                                        </div>
                                </div>

                                <div class="card-body">
                                    <div id="fb-render"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card rounded-0">
                                <div class="card-header">
                                    <h5 class="card-title">

                                        <button class="btn btn-primary btn-sm clipboard float-right" data-clipboard-text="{{ route('formbuilder::form.render', $form->identifier) }}" data-message="Copied" data-original="Copy Form URL" title="Copy form URL to clipboard">
                                            <i class="fa fa-clipboard"></i> Salin dari URL
                                        </button>
                                    </h5>
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Public URL: </strong>
                                        <a href="{{ route('formbuilder::form.render', $form->identifier) }}" class="float-right" target="_blank">
                                            {{$form->identifier}}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Visibilitas: </strong> <span class="float-right">{{ $form->visibility }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Izin Perubahan: </strong>
                                        <span class="float-right">{{ $form->allowsEdit() ? 'YES' : 'NO' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Dibuat Oleh: </strong> <span class="float-right">{{ $form->user->name }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Total Permohonan: </strong>
                                        <span class="float-right">{{ $form->submissions_count }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong> Diubah: </strong>
                                        <span class="float-right">
                                        {{ $form->updated_at->toDayDateTimeString() }}
                                    </span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Dibuat: </strong>
                                        <span class="float-right">
                                        {{ $form->created_at->toDayDateTimeString() }}
                                    </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
<script type="text/javascript">
    window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
</script>
<script src="{{ asset('vendor/formbuilder/js/preview-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
