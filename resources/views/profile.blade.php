@extends('layouts.master')


@section('content')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-profile">
                    <div class="clearfix">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-5">
                            <!-- PROFILE HEADER -->
                            <div class="profile-header">
                                <div class="overlay"></div>
                                <div class="profile-main">
                                    <img src="{{auth()->user()->pegawai->getFoto()}}" class="img-circle" alt="Avatar">
                                    <h3 class="name">{{auth()->user()->pegawai->nama_lengkap}}</h3>
                                    <span class="online-status status-available">Available</span>
                                </div>
                                <div class="profile-stat">
                                    <div class="row">
{{--                                        @foreach(totalsurat() as $c)--}}
                                        <div class="col-md-4 stat-item">
                                           {{totalsurat()}} <span>Form Submitted</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            {{formFinish()}} <span>Form Complete</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            {{formReject()}} <span>Form Reject</span>
                                        </div>
{{--                                        @endforeach    --}}
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE HEADER -->
                            <!-- PROFILE DETAIL -->
                            <div class="profile-detail">
                                <div class="profile-info">
                                    <h4 class="heading">Basic Info</h4>
                                    <ul class="list-unstyled list-justify">
                                        <li><b>NIP 1</b> <span>{{auth()->user()->pegawai->nip}}</span></li>
                                        <li><b>NIP 2</b><span>{{auth()->user()->pegawai->nip18}}</span></li>
                                        <li><b>Phone Number</b> <span>{{auth()->user()->pegawai->no_hp}}</span></li>
                                        <li><b>Email</b> <span>{{auth()->user()->pegawai->email}}</span></li>
                                        @foreach($data_jabatan as $j)
                                            @if($j->id == auth()->user()->pegawai->jabatan_id)
                                                <li><b>Jabatan</b><span>{{$j->nama_jabatan}}</span></li>
                                            @endif
                                        @endforeach
                                        @foreach($data_unitjab as $uj)
                                            @if($uj->id_unit_jabatan == auth()->user()->pegawai->unit_jabatan_id)
                                                <li><b>Unit Jabatan</b> <span>{{$uj->unit}}</span></li>
                                            @endif
                                        @endforeach
                                        @foreach($data_unit as $u)
                                            @if($u->id == auth()->user()->pegawai->unit_id)
                                                <li><b>Unit </b><span>{{$u->nama_unit}}</span></li>
                                            @endif
                                        @endforeach
                                        <li><b>Status </b><span class="label label-success">{{auth()->user()->pegawai->status}}</span></li>
                                    </ul>
                                    <div class="text-center"><a href="/pegawai/{{auth()->user()->pegawai->id}}/edit" class="btn btn-primary">Edit Profile</a></div>
                                </div>


                            </div>
                            <!-- END PROFILE DETAIL -->
                        </div>
                        <!-- END LEFT COLUMN -->
                        <!-- RIGHT COLUMN -->
                        <div class="col-md-6">

                            <!-- END AWARDS -->
                            <!-- TABBED CONTENT -->
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
{{--                                                <i class="fa fa-comment activity-icon"></i>--}}
{{--                                                <i class="fa fa-check activity-icon"></i>--}}
{{--                                                <i class="fa fa-cloud-upload activity-icon"></i>--}}
                                                <i class="fa fa-comment activity-icon"></i>
                                                <p>{{$d->subject}}<span class="timestamp">{{\Carbon\Carbon::parse($d->created_at)->diffForHumans()}}</span></p>
                                            </li>
                                            @endforeach
                                    </ul>
                                    </div>
                            </div>
                            <!-- END TABBED CONTENT -->
                        </div>
                        <!-- END RIGHT COLUMN -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>

@endsection


