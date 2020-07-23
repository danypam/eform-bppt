@extends('formbuilder::layout')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-builder.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-render.min.js') }}" defer></script>
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
                                <div class="btn-toolbar float-md-right margin-bottom-30" role="toolbar">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-sm btn-primary float-md-right">
                                            <i class="fa fa-arrow-left"></i> Back To My Forms
                                        </a>
                                        <button class="btn btn-primary btn-sm clipboard" data-clipboard-text="{{ route('formbuilder::form.render', $form->identifier) }}" data-message="Link Copied" data-original="Copy Form Link" title="Copy form URL to clipboard">
                                            <i class="fa fa-clipboard"></i> Copy Form Link
                                        </button>
                                    </div>
                                </div>
                                <form action="{{ route('formbuilder::forms.update', $form) }}" method="POST" id="createFormForm" data-form-method="PUT">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">Form Name</label>
                                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $form->name }}" required autofocus placeholder="Enter Form Name">
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
                                                            <option value="{{ $option['id'] }}" @if($form->visibility == $option['id']) selected @endif>
                                                                {{ $option['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('visibility'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('visibility') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4" @if($form->isPublic()) style="display: none;" id="allows_edit_DIV" @endif>
                                                <div class="form-group">
                                                    <label for="allows_edit" class="col-form-label">
                                                        Allow Submission Edit
                                                    </label>

                                                    <select name="allows_edit" id="allows_edit" class="form-control" required="required">
                                                        <option value="0" @if($form->allows_edit == 0) selected @endif>
                                                            NO (submissions are final)
                                                        </option>
                                                        <option value="1" @if($form->allows_edit == 1) selected @endif>
                                                            YES (allow users to edit their submissions)
                                                        </option>
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
                                                    <input id="letter-code" value="{{$form->letter_code}}" type="text" class="form-control" required placeholder="Enter Letter Code" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pic" class="col-form-label" style="display: block">PIC</label>
                                                    <select id="pic" class="selectpicker" multiple data-live-search="true"  data-width="100%" required>
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
                                                    Klik pada komponen yang ada di sebelah kanan, dan tarik ke area yang disediakan</i><br>
                                                    <br>
                                                </div>
                                                <div class="alert alert-info" role="alert">
                                                    <h5><i class="fa fa-info-circle"></i>
                                                        Tips
                                                        <br>
                                                        <br> Anda bisa menambahkan kolom dengan cara menuliskan "row-(jumlah baris) column-md-(lebar kolom) pada kolom class"
                                                        <br>
                                                        <br>Contoh : "row-1 col-md-6"
                                                        <br>col-md-6 = 50% width
                                                        <br>col-md-4 = 33% width
                                                        <br>col-md-2 = 25% width
                                                        <br>Perubahan bisa dilihat di preview
                                                    </h5>
                                                </div>

                                                <div id="fb-editor" class="fb-editor"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card-footer" id="fb-editor-footer" style="display: none;">
                                    <button type="button" class="btn btn-primary fb-clear-btn">
                                        <i class="fa fa-remove"></i> Hapus Formulir
                                    </button>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-warning fb-preview ">
                                        <i class="fa fa-eye"></i> Preview
                                    </button>
                                    <button type="button" class="btn btn-primary fb-save-btn">
                                        <i class="fa fa-save"></i> Simpan Formulir
                                    </button>
                                </div>
                            </div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('footer')
    <script src="{{asset("js/dynamic-form.js")}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
@push(config('formbuilder.layout_js_stack', 'scripts'))
<script>

    $(document).ready(function (){
        var data = {!! $form->pic /*json_decode($form->pic, true)*/ !!};
        console.log(data.toString());

        $.each(data.toString().split(","), function(i,e){
            $("#pic option[value='" + e + "']").prop("selected", true);
        });
    });
</script>

<script type="text/javascript">
    window.FormBuilder = window.FormBuilder || {}
    window.FormBuilder.form_roles = @json($form_roles);

    window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
</script>
<script src="{{ asset('vendor/formbuilder/js/create-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
