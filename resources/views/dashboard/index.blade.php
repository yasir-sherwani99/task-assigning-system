@extends('layouts.app')

@section('style')
    <link href="{{ asset('admin-assets/plugins/lightpicker/litepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @role('admin')
        <h4>Admin Dashboard</h4>
    @endrole
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Projects', 'count' => $stats['total_projects'], 'icon' => 'layers']) 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Tasks', 'count' => $stats['total_tasks'], 'icon' => 'check-square']) 
        </div> <!--end col-->                         
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Clients', 'count' => $stats['total_clients'], 'icon' => 'clock']) 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Budget', 'count' => '$24100', 'icon' => 'dollar-sign'])  
        </div> <!--end col-->                               
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-8">
            @include('dashboard.inc.chart')
        </div> <!--end col--> 
        <div class="col-lg-4">
            @include('dashboard.inc.calendar')
        </div><!--end col-->
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-4">
            @include('dashboard.inc.task_performance_chart')
        </div> <!--end col--> 
        <div class="col-lg-8">
            @include('dashboard.inc.project_progress_report')
        </div><!--end col-->
    </div><!--end row-->

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/lightpicker/litepicker.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <!-- <script src="{{ asset('admin-assets/pages/projects-index.init.js') }}"></script> -->
    <script>
        // Radial
        var options = {
            chart: {
                type: 'radialBar',
                height: 295,
                dropShadow: {
                    enabled: true,
                    top: 5,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    blur: 5,
                    color: '#45404a2e',
                    opacity: 0.35
                },
            },
            plotOptions: {
                radialBar: {
                    offsetY: -10,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 5,
                        size: '50%',
                        background: 'transparent',  
                    },
                    track: {
                        show: false,
                    },
                    dataLabels: {
                        name: {
                            fontSize: '18px',
                        },
                        value: {
                            fontSize: '16px',
                            color: '#50649c',
                        },
                        
                    }
                },
            },
            colors: ["#1b9269","#ff9f43","#2a76f4"],
            stroke: {
                lineCap: 'round'
            },
            series: [{{ $taskPercentage['completed'] }}, {{ $taskPercentage['in_progress'] }}, {{ $taskPercentage['open'] }}],
            labels: ['Completed', 'In Progress', 'Open'],
            legend: {
                show: true,
                floating: true,
                position: 'left',
                offsetX: -10,
                offsetY: 0,
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: true,
                        floating: true,
                        position: 'left',
                        offsetX: 10,
                        offsetY: 0,
                    }
                }
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#task_status"),
            options
        );

        chart.render();
    </script>
@endsection







