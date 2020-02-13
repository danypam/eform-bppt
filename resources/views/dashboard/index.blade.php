@extends('layouts.master')

@section('content')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Submissions Total</h3>
                        <p class="panel-subtitle"></p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-download"></i></span>
                                    <p>
                                        <span class="number">{{$status['all']}}</span><br>
                                        <span class="title label label-default">Submissions</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                    <p>
                                        <span class="number">{{$status['new']}}</span><br>
                                        <span class="title label label-warning">New</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">{{$status['pending']}}</span><br>
                                        <span class="title label label-warning">Pending</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <p>
                                        <span class="number">{{$status['onGoing']}}</span><br>
                                        <span class="title label label-info">On Going</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">{{$status['completed']}}</span><br>
                                        <span class="title label label-success">Completed</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">{{$status['rejected']}}</span><br>
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
                                    <li class="active" id="tab-status"><a href="">By Status</a></li>
                                    <li id="tab-month"><a href="">By Month</a></li>
                                    <li id="tab-year"><a href="">By Year</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div id="status" class="active">
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
                                                <br><span>{{$d->text}} </span>
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

@endsection

@section('footer')

<script>
    // CHART 1 //
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
                text: 'Total(pcs)'
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
        series: {!! json_encode($chart1['series']) !!}
    });

    //CHART 2//
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
                text: 'Total(pcs)'
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

    //CHART 3//
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
                text: 'Total(pcs)'
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
            $( "#month" ).addClass( "hidden" );
            $( "#year" ).addClass( "hidden");
            $( "#status" ).removeClass( "hidden");

            $( "#tab-status" ).addClass( "active");
            $( "#tab-month" ).removeClass( "active");
            $( "#tab-year" ).removeClass( "active");

        });
        $( "#tab-month" ).on('click', function() {
            $( "#month" ).removeClass( "hidden" );
            $( "#status" ).addClass( "hidden" );
            $( "#year" ).addClass( "hidden" );

            $( "#tab-month" ).addClass( "active");
            $( "#tabstatus" ).removeClass( "active");
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
