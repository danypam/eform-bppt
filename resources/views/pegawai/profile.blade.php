@extends('layouts.master')


@section('content')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel">
                    <div class="clearfix">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-5">
                            <!-- PROFILE HEADER -->
                            <div class="profile-header">
                                <div class="overlay"></div>
                                <div class="profile-main">
                                    <img src="{{$data_pegawai->getFoto()}}" class="img-circle" alt="Avatar">
                                    <h3 class="name">{{$data_pegawai->nama_lengkap}}</h3>
                                    <span class="online-status status-available">Available</span>
                                </div>
                                <div class="profile-stat">
                                    <div class="row">
                                        <div class="col-md-4 stat-item">
                                            45 <span>Projects</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            15 <span>Awards</span>
                                        </div>
                                        <div class="col-md-4 stat-item">
                                            2174 <span>Points</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE HEADER -->
                            <!-- PROFILE DETAIL -->
                            <div class="profile-detail">
                                <div class="profile-info">
                                    <h4 class="heading">Basic Info</h4>
                                    <ul class="list-unstyled list-justify">
                                        <li><b>NIP 1</b> <span>{{$data_pegawai->nip}}</span></li>
                                        <li><b>NIP 2</b><span>{{$data_pegawai->nip18}}</span></li>
                                        <li><b>Phone Number</b> <span>{{$data_pegawai->no_hp}}</span></li>
                                        <li><b>Email</b> <span>{{$data_pegawai->email}}</span></li>
                                        @foreach($data_jabatan as $j)
                                            @if($j->id == $data_pegawai->jabatan_id)
                                                <li><b>Jabatan</b><span>{{$j->nama_jabatan}}</span></li>
                                            @endif
                                        @endforeach
                                        @foreach($data_unitjab as $uj)
                                            @if($uj->id_unit_jabatan == $data_pegawai->unit_jabatan_id)
                                                <li><b>Unit Jabatan</b> <span>{{$uj->unit}}</span></li>
                                            @endif
                                        @endforeach
                                        @foreach($data_unit as $u)
                                            @if($u->id == $data_pegawai->unit_id)
                                                <li><b>Unit </b><span>{{$u->nama_unit}}</span></li>
                                            @endif
                                        @endforeach
                                        <li><b>Status </b><span class="label label-success">{{$data_pegawai->status}}</span></li>
                                    </ul>
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
                                        <li>
                                            <i class="fa fa-comment activity-icon"></i>
                                            <p>Commented on post <a href="#">Prototyping</a> <span class="timestamp">2 minutes ago</span></p>
                                        </li>
                                        <li>
                                            <i class="fa fa-cloud-upload activity-icon"></i>
                                            <p>Uploaded new file <a href="#">Proposal.docx</a> to project <a href="#">New Year Campaign</a> <span class="timestamp">7 hours ago</span></p>
                                        </li>
                                        <li>
                                            <i class="fa fa-plus activity-icon"></i>
                                            <p>Added <a href="#">Martin</a> and <a href="#">3 others colleagues</a> to project repository <span class="timestamp">Yesterday</span></p>
                                        </li>
                                        <li>
                                            <i class="fa fa-check activity-icon"></i>
                                            <p>Finished 80% of all <a href="#">assigned tasks</a> <span class="timestamp">1 day ago</span></p>
                                        </li>
                                    </ul>
                                    <div class="margin-top-30 text-center"><a href="#" class="btn btn-default">See all activity</a></div>
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

