<?php

namespace App\Repositories\Eloquent\Backend\Organization;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Vaccine;
use Exception;
use Generator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @class EnumeratorRepository
 */
class VaccineRepository extends EloquentRepository
{
    /**
     * EnumeratorRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new Vaccine);
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


        if (!empty($filters['enabled'])) {
            $query->where('enabled', '=', $filters['enabled']);
        }

        if (!empty($filters['nid'])) {
            $query->where('nid', '=', $filters['nid']);
        }

        if (!empty($filters['sort']) && !empty($filters['direction'])) {
            $query->orderBy($filters['sort'], $filters['direction']);
        }

        if ($is_sortable == true) {
            $query->sortable();
        }

        if (!empty($filters['metric'])) {
            $symptomVariation = $filters['symptomVariation'] ?? 'symptom1';
            switch ($filters['metric']) {
                case 'top_10_symptoms':
                    if (!is_joined($query, 'symptoms')) {
                        $query->join('symptoms', 'symptoms.vaers_id', '=', 'vaccines.vaers_id');
                    }
                    $query->selectRaw("vax_name, symptoms.{$symptomVariation}, count(symptoms.{$symptomVariation}) as aggregate")
                        ->groupBy('vax_name', $filters['symptomVariation'])
                        ->orderBy('aggregate', 'desc')
                        ->limit(20);
                    /*                    if (! empty($filters['gender'])) {
                                            $query->join('patients', 'patients.vaers_id', '=', 'symptoms.vaers_id')
                                                ->where('patients.sex', 'like', "%{$filters['gender']}%");
                                        }*/
                    break;

                case 'total_vaccines' :
                    $query->selectRaw("COUNT(vaccines.id) as aggregate");
                    break;
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
