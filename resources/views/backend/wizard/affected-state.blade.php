<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">State wise Patients count</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="d-md-flex">
                <div class="p-1 flex-fill" style="overflow: hidden">
                    <div id="world-map-markers" style="overflow: hidden" class="mapael">
                        <div class="map"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('plugin-script')
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
@endpush

@push('page-script')
    <script>
        $(document).ready(function () {
            $('#world-map-markers').mapael({!!  json_encode($patientsStateMap); !!});
        });
    </script>
@endpush