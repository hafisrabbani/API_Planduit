@extends('Admin.Pages.test.template')

@section('title', 'Dashboard')
@section('meta-tag')
    <meta name="description" content="Dashboard">
@endsection

@section('title', 'Dashboard')
@section('subtitle', 'Dashboard')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dashboard</h4>
            </div>
            <div class="card-body">
                Welcome to Dashboard..
                Enjoy your day!
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Statistics Rating</h4>
                    </div>
                    <div class="card-body">
                        <div id="rating-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        const dataRating = JSON.parse({!! json_encode($dataRatings) !!});
        const ratingChartOptions = {
            series: [{
                name: 'Rating',
                data: dataRating.map(item => item.total)
            }],
            chart: {
                height: 350,
                type: 'bar',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
            },
            plotOptions: {
                bar: {
                    colors: {
                        ranges: [{
                            from: 1,
                            to: 1,
                            color: '#FF5733'
                        },{
                            from: 2,
                            to: 2,
                            color: '#FFBD33'
                        },{
                            from: 3,
                            to: 3,
                            color: '#eee514'
                        },{
                            from: 4,
                            to: 4,
                            color: '#7CFF33'
                        },{
                            from: 5,
                            to: 5,
                            color: '#33FFA8'
                        }]
                    },
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: dataRating.map(item => item.rating),
                labels: {
                    style: {
                        colors: ['#333'],
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                    },
                },
            },
            yaxis: {
                title: {
                    text: 'Total Rating'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val;
                    }
                },
                marker: {
                    show: true,
                },
            }
        };
        const ratingChart = new ApexCharts(document.querySelector("#rating-chart"), ratingChartOptions);
        ratingChart.render();
    </script>
@endpush

