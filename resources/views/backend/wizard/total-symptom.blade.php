<div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
            <h3 id="total_symptom">0</h3>

            <p>Symptoms</p>
        </div>
        <div class="icon">
            <i class="fas fa-viruses"></i>
        </div>
        <a href="{{ route('backend.organization.symptoms.index', request()->all()) }}"
           class="small-box-footer">{!! __('common.More info') !!} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
            $.get('{{ route('backend.model.count', 'symptom') }}', function (data) {
                $("#total_symptom").html(data.count ?? 0);
            })
        });
    </script>
@endpush