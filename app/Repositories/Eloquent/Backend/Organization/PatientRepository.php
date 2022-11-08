<?php

namespace App\Repositories\Eloquent\Backend\Organization;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Patient;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @class SurveyRepository
 */
class PatientRepository extends EloquentRepository
{
    /**
     * SurveyRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new Patient);
    }

    /**
     * Search Function
     *
     * @param  array  $filters
     * @param  bool  $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        foreach ($filters as $key => $value) {
            if (is_null($filters[$key])) {
                unset($filters[$key]);
            }
        }

        $query = $this->getQueryBuilder();

        if (! empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('enabled', '=', "%{$filters['search']}%");
        }

        if (! empty($filters['year'])) {
            $query->where(DB::raw('YEAR(`recive_date`)'), '=', $filters['year']);
        }

        if (! empty($filters['sex'])) {
            $query->where('sex', '=', $filters['sex']);
        }

        if (! empty($filters['age'])) {
            $query->where('age_yrs', '=', $filters['age']);
        }

        if (! empty($filters['state'])) {
            $query->where('state', '=', strtoupper($filters['state']));
        }

        if (! empty($filters['symptom'])) {
            $query->where('symptom_text', 'like', "%{$filters['symptom']}%");
        }

        if (! empty($filters['recovered'])) {
            $query->where('recovd', '=', 'Y');
        }

        if (! empty($filters['died'])) {
            $query->where('died', '=', 'Y');
        }

        if (! empty($filters['hospitalized'])) {
            $query->where('hospital', '=', 'Y');
        }

        if (! empty($filters['sort']) && ! empty($filters['direction'])) {
            $query->sortable($filters['sort'], $filters['direction']);
        }

        if ($is_sortable == true) {
            $query->sortable();
        }

        if (! empty($filters['year_distinct'])) {
            $query->selectRaw('YEAR(`todays_date`) as `year`')
                ->whereNotNull('todays_date')
                ->where(DB::raw('YEAR(`todays_date`)'), '>', '2018')
                ->distinct();
        }

        if (! empty($filters['metric'])) {
            switch ($filters['metric']) {
                case 'sex':
                    $query->selectRaw("sum(if(`sex` = 'F', 1, 0)) as 'Female', ".
                        "sum(if(`sex` = 'M', 1, 0)) as 'Male', ".
                        "sum(if(`sex` = 'U', 1, 0)) as 'Unknown'");
                    break;

                case 'age_yrs':

                    $query->selectRaw("sum(if(`age_yrs` < 10, 1, 0)) as '0.0-10.0', ".
                        "sum(if(`age_yrs` between 10 and 20, 1, 0)) as '10.1-20.0', ".
                        "sum(if(`age_yrs` between 20 and 30, 1, 0)) as '20.1-30.0', ".
                        "sum(if(`age_yrs` between 30 and 40, 1, 0)) as '30.1-40.0', ".
                        "sum(if(`age_yrs` between 40 and 50, 1, 0)) as '40.1-50.0', ".
                        "sum(if(`age_yrs` between 50 and 60, 1, 0)) as '50.1-60.0', ".
                        "sum(if(`age_yrs` between 60 and 70, 1, 0)) as '60.1-70.0', ".
                        "sum(if(`age_yrs` > 70, 1, 0)) as '70.1-INF' ");
                    break;

                case 'patient_month' :

                    $query->selectRaw(
                        "sum(if(`todays_date` between '{$filters['today_year']}-01-01' and '{$filters['today_year']}-01-31', 1, 0)) as 'January', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-02-01' and '{$filters['today_year']}-02-31', 1, 0)) as 'February', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-03-01' and '{$filters['today_year']}-03-31', 1, 0)) as 'March', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-04-01' and '{$filters['today_year']}-04-31', 1, 0)) as 'April', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-05-01' and '{$filters['today_year']}-05-31', 1, 0)) as 'May', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-06-01' and '{$filters['today_year']}-06-31', 1, 0)) as 'June', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-07-01' and '{$filters['today_year']}-07-31', 1, 0)) as 'July', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-08-01' and '{$filters['today_year']}-08-31', 1, 0)) as 'August', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-09-01' and '{$filters['today_year']}-09-31', 1, 0)) as 'September', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-10-01' and '{$filters['today_year']}-10-31', 1, 0)) as 'October', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-11-01' and '{$filters['today_year']}-11-31', 1, 0)) as 'November', ".
                        "sum(if(`todays_date` between '{$filters['today_year']}-12-01' and '{$filters['today_year']}-12-31', 1, 0)) as 'December'");

                    break;
                case 'state' :
                    $query
                        ->selectRaw('count(`id`) as `aggregate`, `state`')
                        ->whereNotNull('state')
                        ->where(DB::raw('LENGTH(`state`)'), '>', 0)
                        ->orderBy('state')
                        ->groupBy('state');

                default:
                    $query = $query;
            }
        }

        return $query;
    }

    /**
     * Pagination Generator
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @param  bool  $is_sortable
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function paginateWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false): LengthAwarePaginator
    {
        $query = $this->getQueryBuilder();

        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->paginate($this->itemsPerPage);
        }
    }

    /**
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @param  bool  $is_sortable
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false)
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->get();
        }
    }
}
