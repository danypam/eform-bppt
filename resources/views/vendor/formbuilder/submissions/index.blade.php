@extends('formbuilder::layout')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $pageTitle }} ({{ $submissions->count() }})</h3>
                            </div>
                            <div class="panel-body">
                                @if($submissions->count())
                                    <div class="table-responsive">
                                        <table class="table table-bordered d-table table-striped pb-0 mb-0">
                                            <thead>
                                            <tr>
                                                <th class="five">#</th>
                                                <th class="fifteen">Nama Pegawai</th>
                                                @foreach($form_headers as $header)
                                                    <th>{{ $header['label'] ?? title_case($header['name']) }}</th>
                                                @endforeach
                                                <th class="fifteen">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($submissions as $submission)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $submission->user->name ?? 'n/a' }}</td>
                                                    @foreach($form_headers as $header)
                                                        <td>
                                                            {{
                                                                $submission->renderEntryContent(
                                                                    $header['name'], $header['type'], true
                                                                )
                                                            }}
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <a href="{{ route('formbuilder::forms.submissions.show', [$form, $submission->id]) }}" class="btn btn-primary btn-sm" title="Lihat Permohonan">
                                                            <i class="fa fa-eye"></i> Lihat
                                                        </a>

                                                        <form action="{{ route('formbuilder::forms.submissions.destroy', [$form, $submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Batalkan Permohonan?" title="Batalkan Permohonan">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($submissions->hasPages())
                                        <div class="card-footer mb-0 pb-0">
                                            <div>{{ $submissions->links() }}</div>
                                        </div>
                                    @endif
                                @else
                                    <div class="card-body">
                                        <h4 class="text-danger text-center">
                                            Tidak ada permohonan.
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
@endsection
