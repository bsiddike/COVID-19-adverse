<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Models\Symptom;
use App\Repositories\Eloquent\Backend\Organization\SymptomRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * @class SymptomService
 */
class SymptomService extends Service
{
    /**
     * @var SymptomRepository
     */
    private $symptomRepository;

    /**
     * SymptomService constructor.
     *
     * @param  SymptomRepository  $symptomRepository
     */
    public function __construct(SymptomRepository $symptomRepository)
    {
        $this->symptomRepository = $symptomRepository;
        $this->symptomRepository->itemsPerPage = 10;
    }

    /**
     * Get All Symptom models as collection
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return Builder[]|Collection
     *
     * @throws Exception
     */
    public function getAllSymptoms(array $filters = [], array $eagerRelations = [])
    {
        return $this->symptomRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Symptom Model Pagination
     *
     * @param  array  $filters
     * @param  array  $eagerRelations
     * @return LengthAwarePaginator
     *
     * @throws Exception
     */
    public function symptomPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->symptomRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Symptom Model
     *
     * @param  int  $id
     * @param  bool  $purge
     * @return mixed
     *
     * @throws Exception
     */
    public function getSymptomById($id, bool $purge = false)
    {
        return $this->symptomRepository->show($id, $purge);
    }

    /**
     * Save Symptom Model
     *
     * @param  array  $inputs
     * @return array
     *
     * @throws Exception
     * @throws Throwable
     */
    public function storeSymptom(array $inputs): array
    {
        $newSymptomInfo = $this->formatSymptomInfo($inputs);
        DB::beginTransaction();
        try {
            $newSymptom = $this->symptomRepository->create($newSymptomInfo);
            if ($newSymptom instanceof Symptom) {
                //handling Survey List
                $newSymptom->surveys()->attach($inputs['survey_id']);
                $newSymptom->previousPostings()->attach($inputs['prev_post_state_id']);
                $newSymptom->futurePostings()->attach($inputs['future_post_state_id']);
                $newSymptom->save();

                DB::commit();

                return ['status' => true, 'message' => __('New Symptom Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                Log::error('Symptom Create Rollback', [$newSymptomInfo]);
                DB::rollBack();

                return ['status' => false, 'message' => __('New Symptom Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->symptomRepository->handleException($exception);
            Log::error('Symptom Create Exception');
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
    private function formatSymptomInfo(array $inputs)
    {
        $symptomInfo = [];
        $symptomInfo['survey_id'] = null;
        $symptomInfo['gender_id'] = $inputs['gender_id'] ?? null;
        $symptomInfo['dob'] = $inputs['dob'] ?? null;
        $symptomInfo['name'] = $inputs['name'] ?? null;
        $symptomInfo['name_bd'] = $inputs['name_bd'] ?? null;
        $symptomInfo['father'] = $inputs['father'] ?? null;
        $symptomInfo['father_bd'] = $inputs['father_bd'] ?? null;
        $symptomInfo['mother'] = $inputs['mother'] ?? null;
        $symptomInfo['mother_bd'] = $inputs['mother_bd'] ?? null;
        $symptomInfo['nid'] = $inputs['nid'] ?? null;
        $symptomInfo['mobile_1'] = $inputs['mobile_1'] ?? null;
        $symptomInfo['mobile_2'] = $inputs['mobile_2'] ?? null;
        $symptomInfo['email'] = $inputs['email'] ?? null;
        $symptomInfo['present_address'] = $inputs['present_address'] ?? null;
        $symptomInfo['present_address_bd'] = $inputs['present_address_bd'] ?? null;
        $symptomInfo['permanent_address'] = $inputs['permanent_address'] ?? null;
        $symptomInfo['permanent_address_bd'] = $inputs['permanent_address_bd'] ?? null;
        $symptomInfo['exam_level'] = $inputs['exam_level'] ?? null;
        $symptomInfo['whatsapp'] = $inputs['whatsapp'] ?? null;
        $symptomInfo['facebook'] = $inputs['facebook'] ?? null;

        $symptomInfo['is_employee'] = $inputs['is_employee'] ?? 'no';
        $symptomInfo['designation'] = null;
        $symptomInfo['company'] = null;

        if ($symptomInfo['is_employee'] == 'yes') {
            $symptomInfo['designation'] = $inputs['designation'] ?? null;
            $symptomInfo['company'] = $inputs['company'] ?? null;
        }

        return $symptomInfo;
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
     * Update Symptom Model
     *
     * @param  array  $inputs
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function updateSymptom(array $inputs, $id): array
    {
        $newSymptomInfo = $this->formatSymptomInfo($inputs);
        DB::beginTransaction();
        try {
            $symptom = $this->symptomRepository->show($id);
            if ($symptom instanceof Symptom) {
                if ($this->symptomRepository->update($newSymptomInfo, $id)) {
                    //handling Survey List
                    $symptom->surveys()->sync($inputs['survey_id']);
                    $symptom->previousPostings()->sync($inputs['prev_post_state_id']);
                    $symptom->futurePostings()->sync($inputs['future_post_state_id']);
                    $symptom->save();
                    DB::commit();

                    return ['status' => true, 'message' => __('Symptom Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
                } else {
                    Log::error('Symptom Update Rollback', [$symptom]);
                    DB::rollBack();

                    return ['status' => false, 'message' => __('Symptom Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
                }
            } else {
                return ['status' => false, 'message' => __('Symptom Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->symptomRepository->handleException($exception);
            Log::error('Symptom Update Exception');
            Log::error($exception->getMessage());
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Destroy Symptom Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function destroySymptom($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->symptomRepository->delete($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Symptom is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Symptom is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->symptomRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Restore Symptom Model
     *
     * @param $id
     * @return array
     *
     * @throws Throwable
     */
    public function restoreSymptom($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->symptomRepository->restore($id)) {
                DB::commit();

                return ['status' => true, 'message' => __('Symptom is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!', ];
            } else {
                DB::rollBack();

                return ['status' => false, 'message' => __('Symptom is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!', ];
            }
        } catch (Exception $exception) {
            $this->symptomRepository->handleException($exception);
            DB::rollBack();

            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!', ];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param  array  $filters
     * @return SurveyWiseExport|SymptomWiseExport
     *
     * @throws Exception
     */
    public function exportSymptom(array $filters = [])
    {
        $filterType = $filters['filter'] ?? 'symptom';

        unset($filters['filter']);

        if ($filterType == 'survey') {
            $filters['is_total_survey'] = true;
            $filters['sort'] = 'totalSurvey';
            $filters['direction'] = 'desc';
        }

        return ($filterType == 'symptom')
            ? (new SymptomWiseExport($this->symptomRepository->exportWith($filters)))
            : (new SurveyWiseExport($this->symptomRepository->exportWith($filters)));
    }
}
