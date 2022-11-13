@extends('layouts.frontend')

@section('title', 'Home')

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

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $patients ?? 0 }}</h3>

                        <p>Confirmed Case</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $vaccines ?? 0 }}</h3>

                        <p>Vaccines</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-first-aid"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $patientsDied ?? 0 }}</h3>

                        <p>Died</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sad-tear"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="border-bottom p-1">
                            Novel Corona Virus
                        </h3>
                        Coronaviruses are a large family of viruses that may cause illness in animals or humans.
                        In humans, several coronaviruses cause respiratory infections ranging from the common cold
                        to more severe diseases such as Middle East Respiratory Syndrome (MERS) and Severe Acute
                        Respiratory Syndrome (SARS). The most recently discovered coronavirus causes coronavirus
                        disease COVID-19.
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="border-bottom p-1">
                            what is covid-19
                        </h3>
                        COVID-19 is the infectious disease caused by the most recently discovered coronavirus.
                        This new virus and disease were unknown before the outbreak began in Wuhan, China,
                        in December 2019.
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="border-bottom p-1">
                            How COVID-19 Spreads
                        </h3>
                        The virus spreads mainly from person to person:
                        Between people in close contact with one another (within about 6 feet).
                        Respiratory droplets are produced when an infected person coughs or sneezes.
                        These droplets can land in the mouths or noses of nearby people or possibly be inhaled into the lungs.
                        COVID‑19 may be spread by people who are not showing any symptoms.
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="border-bottom p-1">
                            Prevention of COVID-19
                        </h3>
                        Vaccination is the best tool to protect people and communities from COVID-19.
                        Like any vaccine, COVID-19 vaccines do not stop 100% of cases. But people who
                        are up-to-date on their vaccines. They are also better protected from severe
                        illness, hospitalization, and death. DSHS encourages the voluntary use of
                        masks and other actions as prevention against COVID-19 and other respiratory infections.
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>

    </div>
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
