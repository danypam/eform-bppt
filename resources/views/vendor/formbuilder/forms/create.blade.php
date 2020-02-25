@extends('formbuilder::layout')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
@endsection
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $pageTitle ?? '' }}</h3>
                            </div>
                            <div class="panel-body">
                                <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-sm btn-primary float-md-right">
                                    <i class="fa fa-arrow-left"></i> Back To My Form
                                </a>
                                <form action="{{ route('formbuilder::forms.store') }}" method="POST" id="createFormForm">
                                    @csrf
                                    <div class="card-body margin-bottom-30">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">Form Name</label>

                                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter Form Name">

                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('name') }}</strong>
                                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="visibility" class="col-form-label">Form Visibility</label>

                                                    <select name="visibility" id="visibility" class="form-control" required="required">
                                                        <option value="">Select Form Visibility</option>
                                                        @foreach(jazmy\FormBuilder\Models\Form::$visibility_options as $option)
                                                            <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('visibility'))
                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('visibility') }}</strong>
                                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="display: none;" id="allows_edit_DIV">
                                                <div class="form-group">
                                                    <label for="allows_edit" class="col-form-label">
                                                        Allow Submission Edit
                                                    </label>

                                                    <select name="allows_edit" id="allows_edit" class="form-control" required="required">
                                                        <option value="0">NO (submissions are final)</option>
                                                        <option value="1">YES (allow users to edit their submissions)</option>
                                                    </select>

                                                    @if ($errors->has('allows_edit'))
                                                        <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('allows_edit') }}</strong>
                                                                </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="letter-code" class="col-form-label">Letter Code</label>
                                                    <input id="letter-code" type="text" class="form-control" required placeholder="Enter Letter Code" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pic" class="col-form-label" style="display: block">PIC</label>
                                                    <select id="pic" class="form-control selectpicker" multiple data-live-search="true"  data-width="100%" required>
                                                        @foreach($pegawai as $peg)
                                                            <option value="{{$peg->id}}">{{$peg->nama_lengkap." (".$peg->nip.")"}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-info" role="alert">
                                                    <i class="fa fa-info-circle"></i>
                                                    Click on or drag and drop components onto the main panel to build your form content.
                                                    <i class="fa fa-info-circle"></i>
                                                    You can add multiple column in row by adding "row-(number row) column-md-(width number)"
                                                </div>
                                                <div id="fb-editor" class="fb-editor"></div>
                                            </div>
                                        </div>
                                           <div class="margin-top-30">
                                                <button type="button" class="btn btn-danger fb-clear-btn fb-clear-btn">
                                                    <i class="fa fa-remove"></i> Clear Form
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-warning fb-preview ">
                                                    <i class="fa fa-eye"></i> Preview
                                                </button>
                                                <button type="button" class="btn btn-primary fb-save-btn">
                                                    <i class="fa fa-save"></i> Submit &amp; Save Form
                                                </button>
                                           </div>
                                        </div>
                                    </form>
                                </div>>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Preview</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset("js/dynamic-form.js")}}"></script>
@endsection
@push(config('formbuilder.layout_js_stack', 'scripts'))
<script type="text/javascript">
    window.FormBuilder = window.FormBuilder || {}
    window.FormBuilder.form_roles = @json($form_roles);
</script>
<script src="{{ asset('vendor/formbuilder/js/create-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
