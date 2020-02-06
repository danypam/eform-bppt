@extends('layouts.master')
{{--@extends('formbuilder::layout')--}}

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Viewing my submission for form
                                            <strong>{{ $submission->form->name }}</strong>

                                            <div class="btn-toolbar float-md-right" role="toolbar">
                                                <div class="btn-group" role="group" aria-label="First group">
                                                    <br>
                                                    <a href="{{ route('formbuilder::my-submissions.index') }}" class="btn btn-primary btn-sm" title="Back To My Submissions">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </a>
                                                    @if($submission->form->allowsEdit())
                                                        <a href="{{ route('formbuilder::my-submissions.edit', $submission) }}" class="btn btn-primary btn-sm" title="Edit this submission">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif
                                                    {{-- <form action="{{ route('formbuilder::my-submissions.destroy', [$submission->id]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm rounded-0 confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete submission" title="Delete this submission?">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <table class="table"  style="table-layout: fixed">
                                        @foreach($form_headers as $header)
                                            <tbody style="border: none">
                                            <tr>
                                                <td style="border: none;word-wrap: break-word; width: 20%"><strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong></td>
                                                <td  style="border: none;word-wrap: break-word; width: 80%" class="float-right"><span>{{ $submission->renderEntryContent($header['name'], $header['type']) }}</span></td>
                                            </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <h5 class="card-title">Details</h5>
                                    </div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Form: </strong>
                                            <span class="float-right">{{ $submission->form->name }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Submitted By: </strong>
                                            <span class="float-right">{{ $submission->user->name ?? 'Guest' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Last Updated On: </strong>
                                            <span class="float-right">{{ $submission->updated_at->toDayDateTimeString() }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Submitted On: </strong>
                                            <span class="float-right">{{ $submission->created_at->toDayDateTimeString() }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
