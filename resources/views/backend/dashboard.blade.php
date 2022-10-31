@extends('layouts.app')

@section('title', __('menu-sidebar.Dashboard'))

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" type="text/css">
@endpush

@push('head-script')

@endpush

@section('breadcrumbs', Breadcrumbs::render())

@section('actions'){{--
    <div class="input-group">
        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
        </div>
        <input type="text" class="form-control float-right" id="reservation">
    </div>
    <!-- /.input group -->--}}
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('backend.wizard.total-user')
            @include('backend.wizard.total-enumerator')
            @include('backend.wizard.total-survey')
            @include('backend.wizard.affected-gender')
            <!-- /.container-fluid -->
            @endsection


            @push('plugin-script')

            <!-- OPTIONAL SCRIPTS -->
                <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
                <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
                <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
            @endpush

            @push('page-script')
            <!-- AdminLTE for demo purposes -->
                <script src="{{ asset('assets/js/demo.js') }}"></script>
                <!-- AdminLTE dashboard demo (This is only for d2emo purposes) -->
                {{--            <script src="{{ asset('assets/js/pages/dashboard2.js') }}"></script>--}}
                <script>
                    $(document).ready(function () {
                        //-------------
                        // - PIE CHART -
                        //-------------
                        // Get context with jQuery - using jQuery's .get() method.
                        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                        var pieData = {!!  json_encode($pieData) !!};/*{
                            labels: [
                                'Chrome',
                                'IE',
                                'FireFox',
                                'Safari',
                                'Opera',
                                'Navigator'
                            ],
                            datasets: [
                                {
                                    data: [700, 500, 400, 600, 300, 100],
                                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
                                }
                            ]
                        }*/
                        var pieOptions = {
                            legend: {
                                display: false
                            }
                        }
                        // Create pie or douhnut chart
                        // You can switch between pie and douhnut using the method below.
                        // eslint-disable-next-line no-unused-vars
                        var pieChart = new Chart(pieChartCanvas, {
                            type: 'doughnut',
                            data: pieData,
                            options: pieOptions
                        })

                        //-----------------
                        // - END PIE CHART -
                        //-----------------
                    });
                </script>
    @endpush
