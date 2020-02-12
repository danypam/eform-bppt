@extends('layouts.master')

@section('content')

    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- OVERVIEW -->
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Weekly Overview</h3>
                        <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>
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
                        <div class="panel panel-scrolling">
                            <div class="panel-heading">
                                <h3 class="panel-title">Chart</h3>
                                <div id="chartSurat"></div>
                            </div>
                            <div class="panel-heading">
                                <h3 class="panel-title">Chart</h3>
                                <div id="chartForm"></div>
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
    Highcharts.chart('chartSurat', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Submissions'
        },

        xAxis: {
            categories: {!! json_encode($chart1['category']) !!},
            title: {
                text: null
            }
        },
        yAxis: {
            min: 1,
            title: {
                text: 'Jumlah',
                align: 'medium'
            },
            labels: {
                overflow: 'high'
            }
        },
        tooltip: {
            valueSuffix: ' pieces'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -80,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series:{!! json_encode($chart1['series']) !!},
    });


//CHART 2//

    Highcharts.chart('chartForm', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Submissions'
        },

        xAxis: {
            categories: {!! json_encode($chart2['category']) !!},
            title: {
                text: null
            }
        },
        yAxis: {
            min: 1,
            title: {
                text: 'Jumlah',
                align: 'medium'
            },
            labels: {
                overflow: 'high'
            }
        },
        tooltip: {
            valueSuffix: ' pieces'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -80,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series:{!! json_encode($chart2['series']) !!},
    });

</script>

@endsection
