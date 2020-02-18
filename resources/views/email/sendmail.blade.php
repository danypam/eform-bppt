<!DOCTYPE html>
<html>
<head>
    <title>E-form Service Desk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
<h1>Hello, {{ $detail['name'] }}. You have one form to approved.</h1>

<div class="row">
    <div class="col-md-8">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Viewing Submission #{{ $detail['submission']->id }} for form '{{ $detail['submission']->form->name }}'</h3>
            </div>
            <div class="panel-body">
                <div class="btn-toolbar float-right" role="toolbar">
                    <div class="btn-group" role="group" aria-label="First group">
                        <a href="{{ route('formbuilder::forms.submissions.index', $detail['submission']->form->id) }}" class="btn btn-primary float-md-right btn-sm" title="Back To Submissions">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <table class="table"  style="table-layout: fixed;font-family: sans-serif">

                        <tbody style="border: none">
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Nama Lengkap</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->nama_lengkap}}</td>
                        </tr>
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Email</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->email}}</td>
                        </tr>
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>NIP</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->nip}}</td>
                        </tr>
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Kerja</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->unit_kerja->nama_unit}}</td>
                        </tr>
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Jabatan</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->unit_jabatan->unit}}</td>
                        </tr>
                        <tr>
                            <td style="border: none;word-wrap: break-word; width: 50%"><strong>No HP</strong></td>
                            <td>:</td>
                            <td style="border: none;word-wrap: break-word; width: 50%">{{$detail['identitas']->no_hp}}</td>
                        </tr>
                        {{--                                        --}}
                        @foreach($detail['form_headers'] as $header)
                            <tr>
                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong></td>
                                <td>:</td>
                                <td  style="border: none;word-wrap: break-word; width: 50%" class="float-right"><span>{{ $detail['submission']->renderEntryContent($header['name'], $header['type']) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
{{--        <div class="card rounded-0">--}}
{{--            <div class="card-header">--}}
                <h5 class="card-title">Details</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Form: </strong>
                    <span class="float-right">{{ $detail['submission']->form->name }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Submitted By: </strong>
                    <span class="float-right">{{ $detail['submission']->user->name ?? 'Guest' }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Submitted On: </strong>
                    <span class="float-right">{{ $detail['submission']->updated_at->toDayDateTimeString() }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Last Updated On: </strong>
                    <span class="float-right">{{ $detail['submission']->created_at->toDayDateTimeString() }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Known by: </strong>
                    <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap)? \App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap:'' }}</span>
                </li>
                <li class="list-group-item">
                    <strong>Known at: </strong>
                    <span class="float-right">{{ isset($detail['submission']->mengetahui_at)? $detail['submission']->mengetahui_at: '' }}</span>
                </li>
                <li class="list-group-item"> {{--\App\Http\Controllers\FormController::getNamePic($pic)->nama_lengkap--}}
                    <strong>Approved by: </strong>
                    <span class="float-right">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap) ? \App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap: ''}}</span>
                </li>
                <li class="list-group-item">
                    <strong>Approved at: </strong>
                    <span class="float-right">{{ isset($detail['submission']->menyetujui_at)? $detail['submission']->menyetujui_at: ''}}</span>
                </li>
                <li class="list-group-item">
                    <strong>Completed at: </strong>
                    <span class="float-right">{{ isset($detail['submission']->complete_at)? $detail['submission']->complete_at: ''}}</span>
                </li>
            </ul>
        </div>
{{--    </div>--}}
{{--</div>--}}
<p> Please check this link <a href="{{ $detail['url'] }}">http://inboxbyid</a> for approval</p>
<p>Thank you</p>
</body>
</html>
