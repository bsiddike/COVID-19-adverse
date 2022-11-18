<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\PatientExport;
use App\Models\Backend\Organization\Patient;
use App\Repositories\Eloquent\Backend\Organization\PatientRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class PatientService
 */
class PatientService extends Service
{
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    /**
     * PatientService constructor.
     *
     * @param  PatientRepository  $patientRepository
     */
    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->patientRepository->itemsPerPage = 10;
    }

    public function getGenderMetrics(array $filters = [])
    {
        $filters['metric'] = 'sex';

        $data = $this->getAllPatients($filters)->toArray();

        return [
            'type' => 'doughnut',
            'data' => [
                'labels' => array_keys($data[0]),
                'datasets' => [
                    [
                        'data' => array_values($data[0]),
                        'backgroundColor' => ['#f56954', '#00a65a', '#f39c12'],
                    ],
                ],
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'position' => 'left',
                ],
            ],
        ];
    }

    public function getAgeMetrics(array $filters = [])
    {
        $filters['metric'] = 'age_yrs';

        $data = $this->getAllPatients($filters)->toArray();

        return [
            'type' => 'pie',
            'data' => [
                'labels' => array_keys($data[0]),
                'datasets' => [
                    [
                        'data' => array_values($data[0]),
                        'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#a2d6de'],
                    ],
                ],
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'position' => 'left',
                ],
            ],
        ];
    }

    public function getPatientLineChart(array $filters = [])
    {
        $years = $this->getAllPatients(array_merge($filters, ['year_distinct' => true]))
            ->pluck('year')->toArray();

        $months = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December', ];

        $datasets = [];

        $filters['metric'] = 'patient_month';

        foreach ($years as $year) {
            $color = random_color();
            $filters['today_year'] = $year;
            $data = $this->getAllPatients($filters)->toArray();
            $datasets[] = [
                'label' => $year,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'pointRadius' => false,
                'pointColor' => $color,
                'pointStrokeColor' => $color,
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => $color,
                'data' => array_values($data[0]),
                'fill' => false,
            ];
        }

        return [
            'type' => 'line',
            'data' => [
                'labels' => $months,
                'datasets' => $datasets,
            ],
            'options' => [
                'datasetFill' => true,
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'display' => true,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'gridLines' => [
                                'display' => false,
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'gridLines' => [
                                'display' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getPatientMap(array $filters = [])
    {
        $filters['metric'] = 'state';
        $states = $this->getAllPatients($filters)->toArray();
        $areas = [];

        foreach ($states as $state) {
            $state_name = strtoupper($state['state']);
            $state_count = strtonumber($state['aggregate'], 0);
            $areas[$state_name] = [
                'value' => $state_count,
                'href' => route('frontend.patients.index', array_merge($filters, ['state' => $state_name])),
                //'href' => '#',
                'tooltip' => [
                    'content' => "<span style='font-weight:bold;'>{$state_name}</span><br/>Patients: {$state_count}",
                ],
            ];
        }

        return [
            'map' => [
                'name' => 'usa_states',
                'zoom' => [
                    'enabled' => true,
                    'maxLevel' => 10,
                ],
                'defaultArea' => [
                    'attrs' => [
                        'stroke' => '#fff',
                        'stroke-width' => 1,
                    ],
                    'attrsHover' => [
                        'stroke-width' => 2,
                    ],
                ],
            ],
            'legend' => [
                'area' => [
                    'title' => 'Confirm Case Recorded',
                    'slices' => [
                        [
                            'max' => 100,
                            'attrs' => [
                                'fill' => '#97e766',
                            ],
                            'label' => 'Less than de 100 cases',
                        ],
                        [
                            'min' => 100,
                            'max' => 300,
                            'attrs' => [
                                'fill' => '#7fd34d',
                            ],
                            'label' => 'Between 100  and 300 cases',
                        ],
                        [
                            'min' => 300,
                            'max' => 500,
                            'attrs' => [
                                'fill' => '#5faa32',
                            ],
                            'label' => 'Between 300 and 500 cases',
                        ],
                        [
                            'min' => 500,
                            'attrs' => [
                                'fill' => '#3f7d1a',
                            ],
                            'label' => 'More than 500 cases',
                        ],
                    ],
                ],
            ],
            'areas' => $areas,
        ];
    }

    /**
     * Get All Patient models as collection
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getAllPatients(array $filters = [], array $eagerRelations = [])
    {
        return $this->patientRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Patient Model Pagination
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function patientPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->patientRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Patient Model
     *
     * @param  int  $id
     * @param  bool  $purge
     * @return mixed
     *
     * @throws Exception
     */
    public function getPatientById($id, bool $purge = false)
    {
        return $this->patientRepository->show($id, $purge);
    }

    /**
     * Save Patient Model
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     * @throws Throwable
     */
    public function storePatient(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newPatient = $this->patientRepository->create($inputs);
            if ($newPatient instanceof Patient) {
                DB::commit();

                return ['status' => true, 'message' => __('New Patient Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('New Patient Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->patientRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Update Patient Model
     *
     * @param  array  $inputs
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function updatePatient(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $patient = $this->patientRepository->show($id);
            if ($patient instanceof Patient) {
                if ($this->patientRepository->update($inputs, $id)) {
                    DB::commit();

                    return ['status' => true, 'message' => __('Patient Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
                } else {
                    DB::rollBack();

                    return ['status' => false, 'message' => __('Patient Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
                }
            } else {
                return ['status' => false, 'message' => __('Patient Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->patientRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Destroy Patient Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function destroyPatient($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->patientRepository->delete($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Patient is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Patient is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->patientRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Restore Patient Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function restorePatient($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->patientRepository->restore($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Patient is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Patient is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->patientRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param  array  $filters
     * @return PatientExport
     *
     * @throws Exception
     */
    public function exportPatient(array $filters = []): PatientExport
    {
        return new PatientExport($this->patientRepository->getWith($filters));
    }

    /**
     * Created Array Styled Patient List for dropdown
     *
     * @param  array  $filters
     * @return array
     *
     * @throws Exception
     */
    public function getPatientDropDown(array $filters = [])
    {
        $patients = $this->getAllPatients($filters);
        $patientArray = [];
        foreach ($patients as $patient) {
            $patientArray[$patient->id] = $patient->name;
        }

        return $patientArray;
    }
}
