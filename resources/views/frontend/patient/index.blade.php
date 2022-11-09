@php use App\Models\Vaccine; @endphp
@php use App\Supports\Constant; @endphp
@php use App\Supports\CHTML; @endphp
@extends('layouts.frontend')

@section('title', 'Patients')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('page-style')

@endpush



@section('breadcrumbs', Breadcrumbs::render())

@section('actions')
    {{--    {!! Html::linkButton('Add Patient', 'frontend.patients.create', [], 'fas fa-plus', 'success') !!}--}}
    {{--{!! \Html::bulkDropdown('frontend.surveys', 0, ['color' => 'warning']) !!}--}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('backend.wizard.affected-gender')
            @include('backend.wizard.affected-age-wise')
            @include('backend.wizard.affected-monthly')
            @include('backend.wizard.affected-state')
            @include('backend.wizard.top-10-vaccine-record')
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection


@push('plugin-script')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    {{--<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script> --}}
@endpush

@push('page-script')
    {{--<script>
        /* BOOTSTRAP SLIDER */
        $('.slider').bootstrapSlider()
        //Date range picker
        $('#recive_date').daterangepicker(
            {
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 2018,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: '2019-01-01',
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            }
        )
    </script>--}}
@endpush
