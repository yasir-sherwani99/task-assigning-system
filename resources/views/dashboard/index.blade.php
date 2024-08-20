@extends('layouts.app')

@section('style')
@endsection

@section('content')
    @role('admin')
        <h4>Admin Dashboard</h4>
    @endrole
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Projects', 'count' => $stats['total_projects'], 'icon' => 'layers', 'in_progress' => $stats['projects_in_progress']]) 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Tasks', 'count' => $stats['total_tasks'], 'icon' => 'check-square', 'in_progress' => $stats['tasks_in_progress']]) 
        </div> <!--end col-->                         
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Defects', 'count' => $stats['total_defects'], 'icon' => 'cpu', 'in_progress' => $stats['defects_in_progress']]) 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            @include('dashboard.inc.stats_box', ['title' => 'Clients', 'count' => $stats['total_clients'], 'icon' => 'clock'])
            {{-- @include('dashboard.inc.stats_box', ['title' => 'Budget', 'count' => '$24100', 'icon' => 'dollar-sign'])  --}}
        </div> <!--end col-->                               
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-8">
            @include('dashboard.inc.chart', ['start_date' => $graphData['start_date'], 'end_date' => $graphData['end_date']])
        </div> <!--end col--> 
        <div class="col-lg-4">
            @include('dashboard.inc.calendar')
        </div><!--end col-->
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-4">
            @include('dashboard.inc.task_performance_chart')
        </div> <!--end col--> 
        <div class="col-lg-4">
            @include('dashboard.inc.project_performance_chart', ['projectPercentage' => $projectPercentage])
            {{-- @include('dashboard.inc.project_progress_report') --}}
        </div><!--end col-->
        <div class="col-lg-4">
            @include('dashboard.inc.defect_performance_chart', ['defectPercentage' => $defectPercentage])
        </div><!--end col-->
    </div><!--end row-->

@endsection

@section('script')
    <script src="{{ asset('admin-assets/plugins/lightpicker/litepicker.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        //  Litepicker
        new Litepicker({ 
            element: document.getElementById('light_datepicker'),
            singleMode: true,
            inlineMode: true,
        })
    </script>
    <script>

        let datess = "{{ $graphData['dates'] }}";
        let datesss = JSON.parse(datess.replace(/&quot;/g, '"'));

        let tasks = "{{ $graphData['tasks'] }}";
        let taskss = JSON.parse(tasks.replace(/&quot;/g, '"'));

        let defects = "{{ $graphData['defects'] }}";
        let defectss = JSON.parse(defects.replace(/&quot;/g, '"'));

        var options = {
            chart: {
                height: 225,
                type: 'area',
                stacked: true,
                toolbar: {
                    show: false,
                    autoSelected: 'zoom'
                },
            },
            colors: ['#2a77f4'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: [2, 2],
                dashArray: [0, 4],
                lineCap: 'round'
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 3,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [
                {
                    name: 'New Tasks',
                    data: taskss
                },
                {
                    name: 'New Defects',
                    data: defectss
                }
            ],

            xaxis: {
                type: 'month',
                categories: datesss,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },  
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },                  
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#overview"),
            options
        );

        chart.render();
    </script>
    <script>
        let taskCompleted = "{{ $taskPercentage['completed'] }}"; 
        let taskInProgress = "{{ $taskPercentage['in_progress'] }}"; 
        let taskOpen = "{{ $taskPercentage['open'] }}";
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
            series: [taskCompleted, taskInProgress, taskOpen],
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
    <script>
        let projCompleted = "{{ $projectPercentage['completed'] }}"; 
        let projInProgress = "{{ $projectPercentage['in_progress'] }}"; 
        let projOpen = "{{ $projectPercentage['open'] }}";

        var options = {
            series: [44, 55, 67, 83],
            chart: {
                height: 310,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 10,
                        size: '55%',
                        background: 'transparent',  
                    },
                    dataLabels: {
                        name: {
                            fontSize: '18px',
                        },
                        value: {
                            fontSize: '16px',
                            color: '#50649c',
                        },
                        total: {
                            show: false,
                        },      
                    },
                    track: {
                        show: true,
                    },
                }
            },
            colors: ["#1b9269","#ff9f43","#2a76f4"],
            stroke: {
                lineCap: 'round'
            },
            series: [projCompleted, projInProgress, projOpen],
            labels: ['Completed', 'In Progress', 'Open'],
            legend: {
                show: true,
                floating: true,
                position: 'left',
                offsetX: -10,
                offsetY: 0,
            },
            legend: {
                show: true,
                position: 'bottom',
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
        };

        var chart = new ApexCharts(document.querySelector("#project_status"), options);
        chart.render();

    </script>
    <script>
        let defectSolved = "{{ $defectPercentage['solved'] }}"; 
        let defectInProgress = "{{ $defectPercentage['in_progress'] }}"; 
        let defectOpen = "{{ $defectPercentage['open'] }}";

        var options = {
            chart: {
                height: 305,
                type: 'pie',
                dropShadow: {
                    enabled: true,
                    top: 4,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    blur: 2,
                    color: '#45404a2e',
                    opacity: 0.35
                },
            }, 
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [defectSolved, defectOpen, defectInProgress],
            labels: ["Solved", "Open", "In Progress"],
            colors: ["#0abb87", "#7367f0", "#ff9f43"],
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0,
                offsetY: 5
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]
        }

        var chartData = new ApexCharts(
            document.querySelector("#defect_status"),
            options
        );

        chartData.render();
        // Radial
        // var options = {
        //     chart: {
        //         type: 'radialBar',
        //         height: 295,
        //         dropShadow: {
        //             enabled: true,
        //             top: 5,
        //             left: 0,
        //             bottom: 0,
        //             right: 0,
        //             blur: 5,
        //             color: '#45404a2e',
        //             opacity: 0.35
        //         },
        //     },
        //     plotOptions: {
        //         radialBar: {
        //             offsetY: -10,
        //             startAngle: 0,
        //             endAngle: 270,
        //             hollow: {
        //                 margin: 5,
        //                 size: '50%',
        //                 background: 'transparent',  
        //             },
        //             track: {
        //                 show: false,
        //             },
        //             dataLabels: {
        //                 name: {
        //                     fontSize: '18px',
        //                 },
        //                 value: {
        //                     fontSize: '16px',
        //                     color: '#50649c',
        //                 },
                        
        //             }
        //         },
        //     },
        //     colors: ["#1b9269","#ff9f43","#2a76f4"],
        //     stroke: {
        //         lineCap: 'round'
        //     },
        //     series: [defectSolved, defectInProgress, defectOpen],
        //     labels: ['Solved', 'In Progress', 'Open'],
        //     legend: {
        //         show: true,
        //         floating: true,
        //         position: 'left',
        //         offsetX: -10,
        //         offsetY: 0,
        //     },
        //     responsive: [{
        //         breakpoint: 480,
        //         options: {
        //             legend: {
        //                 show: true,
        //                 floating: true,
        //                 position: 'left',
        //                 offsetX: 10,
        //                 offsetY: 0,
        //             }
        //         }
        //     }]
        // }

        // var chart = new ApexCharts(
        //     document.querySelector("#defect_status"),
        //     options
        // );

        // chart.render();
    </script>
@endsection







