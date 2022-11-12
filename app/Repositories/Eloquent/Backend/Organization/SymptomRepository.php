<?php

namespace App\Repositories\Eloquent\Backend\Organization;

use App\Abstracts\Repository\EloquentRepository;
use App\Models\Symptom;
use Exception;
use Generator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * @param  array  $filters
     * @param  bool  $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        $query = $this->getQueryBuilder();

        if (! empty($filters['symptom1'])) {
            $query->where('symptom1', 'like', "%{$filters['symptom1']}%");
        }

        if (! empty($filters['symptom2'])) {
            $query->where('symptom2', 'like', "%{$filters['symptom2']}%");
        }

        if (! empty($filters['symptom3'])) {
            $query->where('symptom3', 'like', "%{$filters['symptom3']}%");
        }

        if (! empty($filters['symptom4'])) {
            $query->where('symptom4', 'like', "%{$filters['symptom4']}%");
        }

        if (! empty($filters['symptom5'])) {
            $query->where('symptom5', 'like', "%{$filters['symptom5']}%");
        }

        if (!empty($filters['search_column'])) {
            $query->groupBy($filters['search_column']);
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

    /**
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @param  bool  $is_sortable
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
