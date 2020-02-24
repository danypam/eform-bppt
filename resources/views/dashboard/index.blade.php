@extends('layouts.master')

@section('content')
    @can('dashboard-all')
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">



                    <div class="panel-heading">
                        <h3 class="panel-title">Submissions Status</h3>
                        <p class="panel-subtitle">All Time</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-folder-open-o"></i></span>
                                    <p>
                                        <span class="number">{{$status['all']}}</span><br><br>
                                        <span class="title label label-default"> All Submissions</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-user-plus"></i></span>
                                    <p>
                                        <span class="number">{{$status['new']}}</span><br><br>
                                        <span class="title label label-primary">New</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="lnr lnr-warning"></i></span>
                                    <p>
                                        <span class="number">{{$status['pending']}}</span><br><br>
                                        <span class="title label label-warning">Pending</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-id-badge"></i></span>
                                    <p>
                                        <span class="number">{{$status['waitForPic']}}</span><br><br>
                                        <span class="title label label-info">Wait For PIC</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-id-badge"></i></span>
                                    <p>
                                        <span class="number">{{$status['onGoing']}}</span><br><br>
                                        <span class="title label label-info">On Going</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="lnr lnr-checkmark-circle"></i></span>
                                    <p>
                                        <span class="number">{{$status['completed']}}</span><br><br>
                                        <span class="title label label-success">Completed</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="lnr lnr-cross-circle"></i></span>
                                    <p>
                                        <span class="number">{{$status['rejected']}}</span><br><br>
                                        <span class="title label label-danger">Rejected</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END OVERVIEW -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 style="margin-bottom:10px" class="panel-title">CHART</h3>
                                <ul class="nav nav-tabs">
                                    <li class="active" id="tab-status"><a href="#chart">By Status</a></li>
                                    <li id="tab-month"><a href="#chart">By Month</a></li>
                                    <li id="tab-year"><a href="#chart">By Year</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div id="status" class="">
                                    <div id="chart-status"></div>
                                </div>
                                <div id="month" class="hidden">
                                    <div id="chart-month"></div>
                                </div>
                                <div id="year" class="hidden">
                                    <div id="chart-year"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="panel panel-scrolling">
                            <div class="panel-heading">
                                <h3 class="panel-title">Submission by Unit Kerja</h3><br>
                                <ul class="list-group">
                                    @foreach($data_unit as $unit)
                                    <li class="list-group-item list-hover">
                                        <span class="badge">{{$unit->total}}</span>
                                        {{$unit->nama_unit}}
                                    </li>
                                    @endforeach
                                </ul>                                {{--<table class="table table-hover table-striped" >
                                    <thead>
                                    <tr>
                                        <th scope="col" width="50%" class="text-center">Unit Kerja</th>
                                        <th scope="col" width="30%" class="text-center">Total Submission</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td class="text-center"></td>
                                        </tr>

                                    </tbody>

                                </table>--}}

                            </div>
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="panel panel-scrolling">
                            <div class="panel-heading">
                                <h3 class="panel-title">Recent User Activity</h3>
                                <div class="right">
                                    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                                    <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                                </div>
                            </div>
                            <div class="panel-body">

                                <ul class="list-unstyled activity-list">
                                    @foreach($data as $d)
                                        <li>
                                            <img src="{{auth()->user()->pegawai->getFoto()}}" alt="Avatar" class="img-circle pull-left avatar">
                                            <p><a href="#">{{$d->name}}</a>
                                                <br><span>{{$d->subject}} </span>
                                                <span class="timestamp">{{\Carbon\Carbon::parse($d->created_at)->diffForHumans()}}</span></p>
                                        </li>
                                    @endforeach
                                </ul>

                                <a href="/log" type="button" class="btn btn-primary btn-bottom center-block">Load More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
    @endcan
@endsection

@section('footer')

<script>
    // CHART 1 - STATUS //
    Highcharts.chart('chart-status', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Submission Status'
        },
        xAxis: {
            categories: {!! json_encode($chart1['category']) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (pcs)'
            }
        },
        tooltip: {

            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} </td>' +
                '<td style="padding:0"><b> : {point.y:1f} pcs</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,

        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: {!! json_encode($chart1['series']) !!}
    });

    // CHART 2 - MONTH //
    Highcharts.chart('chart-month', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Submission By Month'
        },
        xAxis: {
            categories: {!! json_encode($chart2['category']) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (pcs)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} </td>' +
                '<td style="padding:0"><b> : {point.y:1f} pcs</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: {!! json_encode($chart2['series']) !!}
    });

    // CHART 3 - YEAR //
    Highcharts.chart('chart-year', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Submission By Year'
        },
        xAxis: {
            categories: {!! json_encode($chart3['category']) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (pcs)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} </td>' +
                '<td style="padding:0"><b> : {point.y:1f} pcs</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: {!! json_encode($chart3['series']) !!}
    });

    $(document).ready(function () {

        $( "#tab-status" ).on('click', function() {
            $( "#status" ).removeClass( "hidden");
            $( "#month" ).addClass( "hidden" );
            $( "#year" ).addClass( "hidden");

            $( "#tab-status" ).addClass( "active");
            $( "#tab-month" ).removeClass( "active");
            $( "#tab-year" ).removeClass( "active");
        });
        $( "#tab-month" ).on('click', function() {
            $( "#month" ).removeClass( "hidden" );
            $( "#status" ).addClass( "hidden" );
            $( "#year" ).addClass( "hidden" )

            $( "#tab-month" ).addClass( "active");
            $( "#tab-status" ).removeClass( "active");
            $( "#tab-year").removeClass( "active");
        });
        $( "#tab-year" ).on('click', function() {
            $( "#year" ).removeClass( "hidden" );
            $( "#status" ).addClass( "hidden" );
            $( "#month" ).addClass( "hidden" );

            $( "#tab-year" ).addClass( "active");
            $( "#tab-status" ).removeClass( "active");
            $( "#tab-month" ).removeClass( "active");
        });
    });
</script>


@endsection
