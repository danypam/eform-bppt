@extends('layouts.master')


@section('content')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-profile">
                    <div class="clearfix">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-14">
                            <!-- PROFILE HEADER -->
                            <div class="profile-header" >
                                <div class="overlay"></div>
                                <div class="profile-main">
                                    <img src="{{auth()->user()->pegawai->getFoto()}}" class="img-circle" alt="Avatar">
                                    <h3 class="name">{{auth()->user()->pegawai->nama_lengkap}}</h3>
                                    <span class="online-status status-available">{{auth()->user()->pegawai->status}}</span>
                                </div>
                                <div class="profile-stat">
                                    <div class="row">
{{--                                        @foreach(totalsurat() as $c)--}}
                                        <div class="col-md-4 stat-item">
                                           {{totalsurat()}} <span>Permohonan</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            {{formFinish()}} <span>Selesai</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            {{formReject()}} <span>Ditolak</span>
                                        </div>
{{--                                        @endforeach    --}}
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE HEADER -->
                            <!-- PROFILE DETAIL -->
                            <!-- END PROFILE DETAIL -->
                        </div>
                        <!-- END LEFT COLUMN -->
                        <!-- RIGHT COLUMN -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="profile-detail">
                                    <div class="profile-info">
                                        <div class="col-md-12">
                                            <table class="table table-borderless table-responsive">
                                                <tbody>
                                                <tr>
                                                    <td><h6><strong>NIP 1</strong></h6></td>
                                                    <td>:</td>
                                                    <td><h6>{{auth()->user()->pegawai->nip}}</h6></td>
                                                </tr>
                                                <tr>
                                                    <td><h6><strong>NIP 2</strong></h6></td>
                                                    <td>:</td>
                                                    <td><h6> {{auth()->user()->pegawai->nip18}}</h6></td>
                                                </tr>
                                                <tr>
                                                    <td><h6><strong>No Handphone</strong></h6></td>
                                                    <td>:</td>
                                                    <td><h6> {{auth()->user()->pegawai->no_hp}}</h6></td>
                                                </tr>
                                                <tr>
                                                    <td><h6><strong>Email</strong></h6></td>
                                                    <td>:</td>
                                                    <td><h6> {{auth()->user()->pegawai->email}}</h6></td>
                                                </tr>
                                                <tr>
                                                    @foreach($data_jabatan as $j)
                                                        @if($j->id == auth()->user()->pegawai->jabatan_id)
                                                            <td><h6><strong>Jabatan</strong></h6></td>
                                                            <td>:</td>
                                                            <td><h6>{{$j->nama_jabatan}}</h6></td>                                                @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach($data_unitjab as $u)
                                                        @if($u->id_unit_jabatan == auth()->user()->pegawai->unit_id)
                                                            <td><h6><strong> Unit Kerja</strong></h6></td>
                                                            <td>:</td>
                                                            <td><h6>{{$u->unit}}</h6></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach($data_unitjab as $uj)
                                                        @if($uj->id_unit_jabatan == auth()->user()->pegawai->unit_jabatan_id)
                                                            <td><h6><strong> Unit Jabatan</strong></h6></td>
                                                            <td>:</td>
                                                            <td><h6>{{$uj->unit}}</h6></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td><h6><strong>Status</strong></h6></td>
                                                    <td>:</td>
                                                    <td><h6 class="label label-success"> {{auth()->user()->pegawai->status}}</h6></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center"><a href="/pegawai/{{auth()->user()->pegawai->id}}/edit" class="btn btn-primary">Ubah Profil</a></div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                    <ul class="nav" role="tablist">
                                        <li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Recent Activity</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-bottom-left1">
                                        <ul class="list-unstyled activity-timeline">
                                            @foreach($data as $d)
                                                <li>
                                                    <i class="fa fa-comment activity-icon"></i>
                                                    <p>{{$d->subject}}<span class="timestamp">{{\Carbon\Carbon::parse($d->created_at)->diffForHumans()}}</span></p>
                                                </li>
                                                @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- END TABBED CONTENT -->
                            </div>
                        </div>
                        <!-- END RIGHT COLUMN -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>

@endsection


