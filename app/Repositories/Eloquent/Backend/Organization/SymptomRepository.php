<?php

namespace App\Repositories\Eloquent\Backend\Organization;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Symptom;
use Exception;
use Generator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @class EnumeratorRepository
 */
class SymptomRepository extends EloquentRepository
{
    /**
     * EnumeratorRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new Symptom);
    }

    /**
     * Search Function
     *
     * @param array $filters
     * @param bool $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        $query = $this->getQueryBuilder();

        if (!empty($filters['gender']) || !empty($filters['age'])
            || !empty($filters['recive_date']) || !empty($filters['search_column'])
            || (!empty($filters['metric']) && in_array($filters['metric'], ['sex', 'age_yrs', 'patient_month']))
            || !empty($filters['symptom']) || !empty($filters['vax_name'])
            || !empty($filters['symptom1']) || !empty($filters['symptom2'])
            || !empty($filters['symptom3']) || !empty($filters['symptom4'])
            || !empty($filters['symptom5'])) {
            $query->join('patients', 'symptoms.vaers_id', '=', 'patients.vaers_id');
        }

        if (!empty($filters['symptom'])) {
            $query->where('symptoms.symptom1', 'like', "%{$filters['symptom']}%");
            $query->orWhere('symptoms.symptom2', 'like', "%{$filters['symptom']}%");
            $query->orWhere('symptoms.symptom3', 'like', "%{$filters['symptom']}%");
            $query->orWhere('symptoms.symptom4', 'like', "%{$filters['symptom']}%");
            $query->orWhere('symptoms.symptom5', 'like', "%{$filters['symptom']}%");
        }

        if (!empty($filters['symptom1'])) {
            $query->where('symptoms.symptom1', 'like', "%{$filters['symptom1']}%");
        }

        if (!empty($filters['symptom2'])) {
            $query->orWhere('symptoms.symptom2', 'like', "%{$filters['symptom2']}%");
        }

        if (!empty($filters['symptom3'])) {
            $query->orWhere('symptoms.symptom3', 'like', "%{$filters['symptom3']}%");
        }

        if (!empty($filters['symptom4'])) {
            $query->orWhere('symptoms.symptom4', 'like', "%{$filters['symptom4']}%");
        }

        if (!empty($filters['symptom5'])) {
            $query->orWhere('symptoms.symptom5', 'like', "%{$filters['symptom5']}%");
        }

        if (!empty($filters['vax_name'])) {
            if (!is_joined($query, 'vaccines')) {
                $query->join('vaccines', 'symptoms.vaers_id', '=', 'vaccines.vaers_id');
            }
            $query->where('vaccines.vax_name', 'like', "%{$filters['vax_name']}%");
        }

        if (!empty($filters['gender'])) {
            $query->where('patients.sex', '=', strtoupper($filters['gender']));
        }

        if (!empty($filters['age'])) {
            $query->whereBetween('patients.age_yrs', explode(",", $filters['age']));
        }

        if (!empty($filters['recive_date'])) {
            $query->whereBetween('patients.recive_date', explode(' - ', $filters['recive_date']));
        }
        if (!empty($filters['other_meds_not_none']) && $filters['other_meds_not_none'] == 'yes') {
            $query->where(DB::raw('LENGTH(patients.other_meds)'), '>', 0)
                ->whereNotIn(DB::raw('LOWER(TRIM(patients.other_meds))'), ['none', '', 'n/a'])
                ->whereNotNull('patients.other_meds');
        }

        if (!empty($filters['metric'])) {
            $symptom_col = $filters['metric_group_column'] ?? 'symptom1';

            switch ($filters['metric']) {
                case 'sex':
                    $select = [DB::raw("symptoms.{$symptom_col} as symptom")];
                    $select[] = DB::raw((isset($filters['gender']) && $filters['gender'] == 'M')
                        ? "0 as female"
                        : "sum(if(patients.sex = 'F', 1, 0)) as female");

                    $select[] = DB::raw((isset($filters['gender']) && $filters['gender'] == 'F')
                        ? "0 as male"
                        : "sum(if(patients.sex = 'M', 1, 0)) as male");

                    $query->select($select)
                        ->groupBy("symptoms.{$symptom_col}")
                        ->orderBy('male', 'desc')
                        ->orderBy('female', 'desc')
                        ->limit(10);
                    break;

                case 'age_yrs':

                    $query->selectRaw("sum(if(patients.age_yrs < 10, 1, 0)) as '0.0-10.0', " .
                        "sum(if(patients.age_yrs between 10 and 20, 1, 0)) as '10.1-20.0', " .
                        "sum(if(patients.age_yrs between 20 and 30, 1, 0)) as '20.1-30.0', " .
                        "sum(if(patients.age_yrs between 30 and 40, 1, 0)) as '30.1-40.0', " .
                        "sum(if(patients.age_yrs between 40 and 50, 1, 0)) as '40.1-50.0', " .
                        "sum(if(patients.age_yrs between 50 and 60, 1, 0)) as '50.1-60.0', " .
                        "sum(if(patients.age_yrs between 60 and 70, 1, 0)) as '60.1-70.0', " .
                        "sum(if(patients.age_yrs > 70, 1, 0)) as '70.1-INF' ");
                    break;

                case 'patient_month':
                    $query->selectRaw(
                        "sum(if(patients.recive_date between '{$filters['today_year']}-01-01' and LAST_DAY('{$filters['today_year']}-01-01'), 1, 0)) as 'January', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-02-01' and LAST_DAY('{$filters['today_year']}-02-01'), 1, 0)) as 'February', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-03-01' and LAST_DAY('{$filters['today_year']}-03-01'), 1, 0)) as 'March', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-04-01' and LAST_DAY('{$filters['today_year']}-04-01'), 1, 0)) as 'April', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-05-01' and LAST_DAY('{$filters['today_year']}-05-01'), 1, 0)) as 'May', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-06-01' and LAST_DAY('{$filters['today_year']}-06-01'), 1, 0)) as 'June', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-07-01' and LAST_DAY('{$filters['today_year']}-07-01'), 1, 0)) as 'July', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-08-01' and LAST_DAY('{$filters['today_year']}-08-01'), 1, 0)) as 'August', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-09-01' and LAST_DAY('{$filters['today_year']}-09-01'), 1, 0)) as 'September', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-10-01' and LAST_DAY('{$filters['today_year']}-10-01'), 1, 0)) as 'October', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-11-01' and LAST_DAY('{$filters['today_year']}-11-01'), 1, 0)) as 'November', " .
                        "sum(if(patients.recive_date between '{$filters['today_year']}-12-01' and LAST_DAY('{$filters['today_year']}-12-01'), 1, 0)) as 'December'");
                    break;
            }
        }

        if (!empty($filters['search_column'])) {
            if ($filters['search_column'] == 'other_meds') {

                $query->select(['symptoms.symptom1', 'symptoms.symptom2', 'symptoms.symptom3', 'symptoms.symptom4', 'symptoms.symptom5', 'patients.other_meds'])
                    ->where(DB::raw('LENGTH(patients.other_meds)'), '>', 0)
                    ->whereNotIn(DB::raw('LOWER(TRIM(patients.other_meds))'), ['none', '', 'n/a'])
                    ->whereNotNull('patients.other_meds');
            }
            $query->groupBy($filters['search_column']);
        }

        return $query;
    }

    /**
     * Pagination Generator
     *
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
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
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false)
    {
        $query = $this->getQueryBuilder();
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->get();
        }
    }

    /**
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return Generator
     *
     * @throws Exception
     */
    public function exportWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false): Generator
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            $collection = $query->with($eagerRelations);
            foreach ($collection->cursor() as $enumerator) {
                yield $enumerator;
            }
        }
    }
}
