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
                                        <span class="number">1,252</span><br>
                                        <span class="title label label-default">Submissions</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                    <p>
                                        <span class="number">203</span><br>
                                        <span class="title label label-warning">New</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">350</span><br>
                                        <span class="title label label-warning">Pending</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <p>
                                        <span class="number">274</span><br>
                                        <span class="title label label-info">On Going</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">350</span><br>
                                        <span class="title label label-success">Completed</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="metric">
                                    <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                    <p>
                                        <span class="number">350</span><br>
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
    Highcharts.chart('chartSurat', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Submissions'
        },
        /*subtitle: {
            text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        },*/
        xAxis: {
            categories: [],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
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
            x: -0,
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
        series: [{
            name: 'form1',
            data: [107, 31, 635, 203, 2]
        }, {
            name: 'form1',
            data: [133, 156, 947, 408, 6]
        }, {
            name: 'form1',
            data: [814, 841, 3714, 727, 31]
        }, {
            name: 'form1',
            data: [1216, 1001, 7436, 738, 40]
        }, {
            name: 'form1',
            data: [1216, 1001, 4436, 738, 40]
        }]
    });


</script>

@endsection

{{--<script>
        Highcharts.chart('chartSurat', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Surat Masuk'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Form Emal'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Surat'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} buah</b></td></tr>',
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
            series: [{
                name: 'Jumlah',
                data: [50, 23]
            },{
                name: 'On Progress',
                data: [10,13]
            },{
                name: 'Complete',
                data: [5,6]
            },{
                name: 'Pending',
                data: [43,12]

            },{
                name: 'Reject',
                data: [1,8]
            }]
        });
    </script>--}}
