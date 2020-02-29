{{--@extends('formbuilder::layout')--}}
@extends('layouts.master')

@section('content')

    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel" style="width: auto">
                            <div class="panel-heading">
                                <h3 class="panel-title">FORMULIR</h3>
                                <div class="right">
                                        <a href="{{ route('formbuilder::forms.create') }}" class="btn btn-info btn-lg">
                                            <i class="fa fa-plus-circle"></i> Tambah Formulir
                                        </a>
                                    </div>
                            </div>
                            <div class="panel-body">
                            @if($forms->count())
                                    <table class="table table-hover"  {{--table-bordered d-table table-striped pb-0 mb-0 --}} id="datatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Formulir</th>
                                                <th>Visibilitas</th>
                                                <th>Izin Perubahan</th>
                                                <th>Total Permohonan</th>
                                                <th>PIC</th>
                                                <th>Dibuat</th>
                                                <th>Diubah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($forms as $form)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $form->name }}</td>
                                                <td>{{ $form->visibility }}</td>
                                                <td>{{ $form->allowsEdit() ? 'YES' : 'NO' }}</td>
                                                <td>{{ $form->submissions_count }}</td>
                                                <td>
                                                    @foreach(json_decode($form->pic) as $pic)
                                                        <b>{{$loop->iteration}}</b>  {{". ". \App\Http\Controllers\FormController::getNamePic($pic)->nama_lengkap . " "}}<hr style='margin:0'>
                                                    @endforeach
                                                </td>
                                                <td>{{ $form->created_at }}</td>
                                                <td>{{ $form->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('formbuilder::forms.submissions.index', $form) }}" class="btn btn-primary btn-sm" title="Pengajuan Formulir '{{ $form->name }}'">
                                                        <i class="fa fa-th-list"></i> Data
                                                    </a>
                                                    <a href="{{ route('formbuilder::forms.show', $form) }}" class="btn btn-success btn-sm" title="Preview Formulir '{{ $form->name }}'">
                                                        <i class="lnr lnr-eye"></i>
                                                    </a>
                                                    <a href="{{ route('formbuilder::forms.edit', $form) }}" class="btn btn-warning btn-sm" title="Ubah Formulir">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('formbuilder::forms.destroy', $form) }}" method="POST" id="deleteFormForm_{{ $form->id }}" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteFormForm_{{ $form->id }}" data-message="Hapus Formulir'{{ $form->name }}'?" title="Delete form '{{ $form->name }}'">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @if($forms->hasPages())
                                    <div class="card-footer mb-0 pb-0">
                                        <div>{{ $forms->links() }}</div>
                                    </div>
                                @endif
                            @else
                                <div class="card-body">
                                    <h4 class="text-danger text-center">
                                        No form to display.
                                    </h4>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop
@section('footer')
            <script>
                $(document).ready(function () {
                    $('#datatable').DataTable({
                        autoWidth: false,
                        scroller:    true,
                    });
                })
            </script>
@stop

