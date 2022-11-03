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
     * @param array $filters
     * @param bool $is_sortable
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

        /* "vaccine_id" => "1996875"*/

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('enabled', '=', "%{$filters['search']}%");
        }

        if (!empty($filters['year'])) {
            $query->where(DB::raw('YEAR(`recive_date`)'), '=', $filters['year']);
        }

        if (!empty($filters['sex'])) {
            $query->where('sex', '=', $filters['sex']);
        }

        if (!empty($filters['age'])) {
            $query->where('age_yrs', '=', $filters['age']);
        }

        if (!empty($filters['state'])) {
            $query->where('state', '=', strtoupper($filters['state']));
        }

        if (!empty($filters['symptom'])) {
            $query->where('symptom_text', 'like', "%{$filters['symptom']}%");
        }

        if (!empty($filters['sort']) && !empty($filters['direction'])) {
            $query->sortable($filters['sort'], $filters['direction']);
        }

        if ($is_sortable == true) {
            $query->sortable();
        }

        if (!empty($filters['metric'])) {

            switch ($filters['metric']) {
                case 'sex' :
                    $query->selectRaw("sum(if(sex = 'F', 1, 0)) as 'Female', ".
                        "sum(if(sex = 'M', 1, 0)) as 'Male', " .
                        "sum(if(sex = 'U', 1, 0)) as 'Unknown'");
                    break;

                case 'age_yrs' :

                    $query->selectRaw("sum(if(age_yrs < 10, 1, 0)) as '0.0-10.0', ".
                        "sum(if(age_yrs between 10 and 20, 1, 0)) as '10.1-20.0', " .
                        "sum(if(age_yrs between 20 and 30, 1, 0)) as '20.1-20.0', " .
                        "sum(if(age_yrs between 30 and 40, 1, 0)) as '30.1-20.0', " .
                        "sum(if(age_yrs between 40 and 50, 1, 0)) as '40.1-20.0', " .
                        "sum(if(age_yrs between 50 and 60, 1, 0)) as '50.1-20.0', " .
                        "sum(if(age_yrs between 60 and 70, 1, 0)) as '60.1-20.0', " .
                        "sum(if(age_yrs > 70, 1, 0)) as '70.1-INF' ");
                    break;

                default :
                    $query = $query;
            }
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
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->get();
        }
    }
}
