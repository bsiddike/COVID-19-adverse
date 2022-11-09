<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Models\Vaccine;
use App\Repositories\Eloquent\Backend\Organization\VaccineRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * @class VaccineService
 */
class VaccineService extends Service
{
    /**
     * @var VaccineRepository
     */
    private $vaccineRepository;

    /**
     * VaccineService constructor.
     *
     * @param  VaccineRepository  $vaccineRepository
     */
    public function __construct(VaccineRepository $vaccineRepository)
    {
        $this->vaccineRepository = $vaccineRepository;
        $this->vaccineRepository->itemsPerPage = 10;
    }

    public function getTopVaccinesOutcomesMetrics(array $filters = [])
    {
        $filters['metric'] = 'top_10_symptoms';

        $data = $this->getAllVaccines($filters)
            ->toArray();

        $formatData = [];

        foreach ($data as $datum) {
            if (! isset($formatData[$datum['vax_name']])) {
                $formatData[$datum['vax_name']] = [
                    'data' => [],
                    'label' => 'Unknown',
                    'backgroundColor' => [],
                ];
            }
            $formatData[$datum['vax_name']]['data'][] = $datum['aggregate'];
            $formatData[$datum['vax_name']]['label'] = $datum['symptom1'];
            $formatData[$datum['vax_name']]['backgroundColor'][] = random_color();
        }

        return [
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($formatData),
                'datasets' => array_values($formatData),
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'datasetFill' => false,
                'responsive' => true,
                'legend' => [
                    'display' => false,
                    'position' => 'left',
                ],
                'scales' => [
                    'xAxes' => [[
                        'stacked' => true,
                    ]],
                    'yAxes' => [[
                        'stacked' => true,
                    ]],
                ],
            ],
        ];
    }

    /**
     * Get All Vaccine models as collection
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getAllVaccines(array $filters = [], array $eagerRelations = [])
    {
        return $this->vaccineRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Vaccine Model Pagination
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function vaccinePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->vaccineRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Vaccine Model
     *
     * @param  int  $id
     * @param  bool  $purge
     * @return mixed
     *
     * @throws Exception
     */
    public function getVaccineById($id, bool $purge = false)
    {
        return $this->vaccineRepository->show($id, $purge);
    }

    /**
     * Save Vaccine Model
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     * @throws Throwable
     */
    public function storeVaccine(array $inputs): array
    {
        $newVaccineInfo = $this->formatVaccineInfo($inputs);
        DB::beginTransaction();
        try {
            $newVaccine = $this->vaccineRepository->create($newVaccineInfo);
            if ($newVaccine instanceof Vaccine) {
                //handling Survey List
                $newVaccine->surveys()->attach($inputs['survey_id']);
                $newVaccine->previousPostings()->attach($inputs['prev_post_state_id']);
                $newVaccine->futurePostings()->attach($inputs['future_post_state_id']);
                $newVaccine->save();

                DB::commit();

                return ['status' => true, 'message' => __('New Vaccine Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                Log::error('Vaccine Create Rollback', [$newVaccineInfo]);
                DB::rollBack();

                return ['status' => false, 'message' => __('New Vaccine Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->vaccineRepository->handleException($exception);
            Log::error('Vaccine Create Exception');
            Log::error($exception->getMessage());
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Return formatted patient profile format array
     *
     * @param  array  $inputs
     * @return array
     */
    private function formatVaccineInfo(array $inputs)
    {
        $vaccineInfo = [];
        $vaccineInfo['survey_id'] = null;
        $vaccineInfo['gender_id'] = $inputs['gender_id'] ?? null;
        $vaccineInfo['dob'] = $inputs['dob'] ?? null;
        $vaccineInfo['name'] = $inputs['name'] ?? null;
        $vaccineInfo['name_bd'] = $inputs['name_bd'] ?? null;
        $vaccineInfo['father'] = $inputs['father'] ?? null;
        $vaccineInfo['father_bd'] = $inputs['father_bd'] ?? null;
        $vaccineInfo['mother'] = $inputs['mother'] ?? null;
        $vaccineInfo['mother_bd'] = $inputs['mother_bd'] ?? null;
        $vaccineInfo['nid'] = $inputs['nid'] ?? null;
        $vaccineInfo['mobile_1'] = $inputs['mobile_1'] ?? null;
        $vaccineInfo['mobile_2'] = $inputs['mobile_2'] ?? null;
        $vaccineInfo['email'] = $inputs['email'] ?? null;
        $vaccineInfo['present_address'] = $inputs['present_address'] ?? null;
        $vaccineInfo['present_address_bd'] = $inputs['present_address_bd'] ?? null;
        $vaccineInfo['permanent_address'] = $inputs['permanent_address'] ?? null;
        $vaccineInfo['permanent_address_bd'] = $inputs['permanent_address_bd'] ?? null;
        $vaccineInfo['exam_level'] = $inputs['exam_level'] ?? null;
        $vaccineInfo['whatsapp'] = $inputs['whatsapp'] ?? null;
        $vaccineInfo['facebook'] = $inputs['facebook'] ?? null;

        $vaccineInfo['is_employee'] = $inputs['is_employee'] ?? 'no';
        $vaccineInfo['designation'] = null;
        $vaccineInfo['company'] = null;

        if ($vaccineInfo['is_employee'] == 'yes') {
            $vaccineInfo['designation'] = $inputs['designation'] ?? null;
            $vaccineInfo['company'] = $inputs['company'] ?? null;
        }

        return $vaccineInfo;
    }

    /**
     * Return formatted education qualification model collection
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     */
    private function formatEducationQualification(array $inputs): array
    {
        $examLevels = $this->examLevelRepository->getWith(['id' => $inputs['exam_level']]);

        $qualifications = [];

        foreach ($examLevels as $examLevel) {
            $prefix = $examLevel->code;
            $qualifications[$examLevel->id]['exam_level_id'] = $inputs["{$prefix}_exam_level_id"] ?? null;
            $qualifications[$examLevel->id]['exam_title_id'] = $inputs["{$prefix}_exam_title_id"] ?? null;
            $qualifications[$examLevel->id]['exam_board_id'] = $inputs["{$prefix}_exam_board_id"] ?? null;
            $qualifications[$examLevel->id]['exam_group_id'] = $inputs["{$prefix}_exam_group_id"] ?? null;
            $qualifications[$examLevel->id]['institute_id'] = $inputs["{$prefix}_institute_id"] ?? null;
            $qualifications[$examLevel->id]['pass_year'] = $inputs["{$prefix}_pass_year"] ?? null;
            $qualifications[$examLevel->id]['roll_number'] = $inputs["{$prefix}_roll_number"] ?? null;
            $qualifications[$examLevel->id]['grade_type'] = $inputs["{$prefix}_grade_type"] ?? null;
            $qualifications[$examLevel->id]['grade_point'] = $inputs["{$prefix}_grade_point"] ?? null;
            $qualifications[$examLevel->id]['enabled'] = 'yes';
        }

        return $qualifications;
    }

    /**
     * Return formatted work experience model collection
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     */
    private function formatWorkQualification(array $inputs): array
    {
        $qualifications = [];

        foreach ($inputs['job'] as $index => $input) {
            $qualifications[$index]['company'] = $input['company'] ?? null;
            $qualifications[$index]['designation'] = $input['designation'] ?? null;
            $qualifications[$index]['start_date'] = $input['start_date'] ?? null;
            $qualifications[$index]['end_date'] = $input['end_date'] ?? null;
            $qualifications[$index]['responsibility'] = $input['responsibility'] ?? null;
            $qualifications[$index]['enabled'] = 'yes';
        }

        return $qualifications;
    }

    /**
     * Update Vaccine Model
     *
     * @param  array  $inputs
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function updateVaccine(array $inputs, $id): array
    {
        $newVaccineInfo = $this->formatVaccineInfo($inputs);
        DB::beginTransaction();
        try {
            $vaccine = $this->vaccineRepository->show($id);
            if ($vaccine instanceof Vaccine) {
                if ($this->vaccineRepository->update($newVaccineInfo, $id)) {
                    //handling Survey List
                    $vaccine->surveys()->sync($inputs['survey_id']);
                    $vaccine->previousPostings()->sync($inputs['prev_post_state_id']);
                    $vaccine->futurePostings()->sync($inputs['future_post_state_id']);
                    $vaccine->save();
                    DB::commit();

                    return ['status' => true, 'message' => __('Vaccine Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
                } else {
                    Log::error('Vaccine Update Rollback', [$vaccine]);
                    DB::rollBack();

                    return ['status' => false, 'message' => __('Vaccine Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
                }
            } else {
                return ['status' => false, 'message' => __('Vaccine Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->vaccineRepository->handleException($exception);
            Log::error('Vaccine Update Exception');
            Log::error($exception->getMessage());
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Destroy Vaccine Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function destroyVaccine($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->vaccineRepository->delete($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Vaccine is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Vaccine is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->vaccineRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Restore Vaccine Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function restoreVaccine($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->vaccineRepository->restore($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Vaccine is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Vaccine is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->vaccineRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param  array  $filters
     * @return SurveyWiseExport|VaccineWiseExport
     *
     * @throws Exception
     */
    public function exportVaccine(array $filters = [])
    {
        $filterType = $filters['filter'] ?? 'vaccine';

        unset($filters['filter']);

        if ($filterType == 'survey') {
            $filters['is_total_survey'] = true;
            $filters['sort'] = 'totalSurvey';
            $filters['direction'] = 'desc';
        }

        return ($filterType == 'vaccine')
            ? (new VaccineWiseExport($this->vaccineRepository->exportWith($filters)))
            : (new SurveyWiseExport($this->vaccineRepository->exportWith($filters)));
    }
}
