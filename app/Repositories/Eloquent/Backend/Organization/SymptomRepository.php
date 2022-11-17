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
            $query->join('vaccines', 'vaccines.vaers_id', "=", "symptoms.vaers_id")
                ->where('vaccines.vax_type', '=', 'COVID19')
                ->orWhere('vaccines.vax_name', 'like', "%{$filters['vax_name']}%");
        }
        if (!empty($filters['gender'])) {
            $query->join('patients', 'patients.vaers_id', "=", "symptoms.vaers_id")
                ->orWhere('patients.sex', 'like', "%{$filters['gender']}%");
        }

        if (!empty($filters['symptom5'])) {
            $query->orWhere('symptoms.symptom5', 'like', "%{$filters['symptom5']}%");
        }

        if (!empty($filters['search_column'])) {
            if ($filters['search_column'] == 'other_meds') {
                $query->select(['symptoms.symptom1', 'symptoms.symptom2', 'symptoms.symptom3', 'symptoms.symptom4', 'symptoms.symptom5', 'patients.other_meds'])
                    ->where(DB::raw('LENGTH(`patients`.`other_meds`)'), '>', 0);
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
