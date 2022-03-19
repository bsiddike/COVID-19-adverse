<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Models\Backend\Organization\Enumerator;
use App\Models\Backend\Organization\Enumerator\EducationQualification;
use App\Models\Backend\Organization\Enumerator\WorkQualification;
use App\Repositories\Eloquent\Backend\Organization\EnumeratorRepository;
use App\Repositories\Eloquent\Backend\Setting\ExamLevelRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class EnumeratorService
 * @package App\Services\Backend\Organization
 */
class EnumeratorService extends Service
{
    /**
     * @var EnumeratorRepository
     */
    private $enumeratorRepository;
    /**
     * @var ExamLevelRepository
     */
    private $examLevelRepository;

    /**
     * EnumeratorService constructor.
     * @param EnumeratorRepository $enumeratorRepository
     * @param ExamLevelRepository $examLevelRepository
     */
    public function __construct(EnumeratorRepository $enumeratorRepository,
                                ExamLevelRepository $examLevelRepository)
    {
        $this->enumeratorRepository = $enumeratorRepository;
        $this->enumeratorRepository->itemsPerPage = 10;
        $this->examLevelRepository = $examLevelRepository;
    }

    /**
     * Get All Enumerator models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllEnumerators(array $filters = [], array $eagerRelations = [])
    {
        return $this->enumeratorRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Enumerator Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function enumeratorPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->enumeratorRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Enumerator Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getEnumeratorById($id, bool $purge = false)
    {
        return $this->enumeratorRepository->show($id, $purge);
    }

    /**
     * Save Enumerator Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeEnumerator(array $inputs): array
    {
        $newEnumeratorInfo = $this->formatEnumeratorInfo($inputs);
        $educationQualifications = $this->formatEducationQualification($inputs);
        $workQualifications = $this->formatWorkQualification($inputs);

        DB::beginTransaction();
        try {
            $newEnumerator = $this->enumeratorRepository->create($newEnumeratorInfo);
            if ($newEnumerator instanceof Enumerator) {
                //handling Education Qualification
                foreach ($educationQualifications as $qualification):
                    $tempQualification = new EducationQualification($qualification);
                    $tempQualification->enumerator()->associate($newEnumerator);
                    $tempQualification->save();
                endforeach;

                //handling Work Qualification
                foreach ($workQualifications as $qualification):
                    $tempQualification = new WorkQualification($qualification);
                    $tempQualification->enumerator()->associate($newEnumerator);
                    $tempQualification->save();
                endforeach;
                DB::commit();
                return ['status' => true, 'message' => __('New Enumerator Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Enumerator Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Return formatted applicant profile format array
     *
     * @param array $inputs
     * @return array
     */
    private function formatEnumeratorInfo(array $inputs)
    {
        $enumeratorInfo = [];
        $enumeratorInfo["survey_id"] = $inputs["survey_id"];
        $enumeratorInfo["name"] = $inputs["name"];
        $enumeratorInfo["name_bd"] = $inputs["name_bd"];
        $enumeratorInfo["father"] = $inputs["father"];
        $enumeratorInfo["father_bd"] = $inputs["father_bd"];
        $enumeratorInfo["mother"] = $inputs["mother"];
        $enumeratorInfo["mother_bd"] = $inputs["mother_bd"];
        $enumeratorInfo["nid"] = $inputs["nid"];
        $enumeratorInfo["mobile_1"] = $inputs["mobile_1"];
        $enumeratorInfo["mobile_2"] = $inputs["mobile_2"];
        $enumeratorInfo["email"] = $inputs["email"];
        $enumeratorInfo["present_address"] = $inputs["present_address"];
        $enumeratorInfo["present_address_bd"] = $inputs["present_address_bd"];
        $enumeratorInfo["permanent_address"] = $inputs["permanent_address"];
        $enumeratorInfo["permanent_address_bd"] = $inputs["permanent_address_bd"];
        $enumeratorInfo["gender_id"] = $inputs["gender_id"];

        return $enumeratorInfo;
    }
    /**
     * Return formatted education qualification model collection
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     */
    private function formatEducationQualification(array $inputs): array
    {
        $examLevels = $this->examLevelRepository->getWith(['id_in' => [1, 2, 3, 4]]);
        $qualifications = [];

        foreach ($examLevels as $examLevel):
            $prefix = $examLevel->code;
            $qualifications[$examLevel->id]["exam_level_id"] = $inputs["{$prefix}_exam_level_id"] ?? null;
            $qualifications[$examLevel->id]["exam_title_id"] = $inputs["{$prefix}_exam_title_id"] ?? null;
            $qualifications[$examLevel->id]["exam_board_id"] = $inputs["{$prefix}_exam_board_id"] ?? null;
            $qualifications[$examLevel->id]["exam_group_id"] = $inputs["{$prefix}_exam_group_id"] ?? null;
            $qualifications[$examLevel->id]["institute_id"] = $inputs["{$prefix}_institute_id"] ?? null;
            $qualifications[$examLevel->id]["pass_year"] = $inputs["{$prefix}_pass_year"] ?? null;
            $qualifications[$examLevel->id]["roll_number"] = $inputs["{$prefix}_roll_number"] ?? null;
            $qualifications[$examLevel->id]["grade_type"] = $inputs["{$prefix}_grade_type"] ?? null;
            $qualifications[$examLevel->id]["grade_point"] = $inputs["{$prefix}_grade_point"] ?? null;
            $qualifications[$examLevel->id]["enabled"] = "yes";
        endforeach;

        return $qualifications;
    }

    /**
     * Return formatted work experience model collection
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     */
    private function formatWorkQualification(array $inputs): array
    {
        $qualifications = [];

        $prefix = "job";
        $qualifications[0]["company"] = $inputs["{$prefix}_company"] ?? null;
        $qualifications[0]["designation"] = $inputs["{$prefix}_designation"] ?? null;
        $qualifications[0]["start_date"] = $inputs["{$prefix}_start_date"] ?? null;
        $qualifications[0]["end_date"] = $inputs["{$prefix}_end_date"] ?? null;
        $qualifications[0]["responsibility"] = $inputs["{$prefix}_responsibility"] ?? null;
        $qualifications[0]["enabled"] = "yes";

        return $qualifications;
    }

    /**
     * Update Enumerator Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateEnumerator(array $inputs, $id): array
    {
        $newEnumeratorInfo = $this->formatEnumeratorInfo($inputs);
        $educationQualifications = $this->formatEducationQualification($inputs);
        $workQualifications = $this->formatWorkQualification($inputs);
        DB::beginTransaction();
        try {
            $enumerator = $this->enumeratorRepository->show($id);
            if ($enumerator instanceof Enumerator) {
                if ($this->enumeratorRepository->update($newEnumeratorInfo, $id)) {
                    //remove existing add models
                    EducationQualification::where('enumerator_id', '=', $enumerator->id)->delete();
                    //load new ones
                    foreach ($educationQualifications as $qualification):
                        $tempQualification = new EducationQualification($qualification);
                        $tempQualification->enumerator()->associate($enumerator);
                        $tempQualification->save();
                    endforeach;

                    //remove existing add models
                    WorkQualification::where('enumerator_id', '=', $enumerator->id)->delete();
                    //load new ones
                    foreach ($workQualifications as $qualification):
                        $tempQualification = new WorkQualification($qualification);
                        $tempQualification->enumerator()->associate($enumerator);
                        $tempQualification->save();
                    endforeach;

                    DB::commit();
                    return ['status' => true, 'message' => __('Enumerator Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Enumerator Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Enumerator Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Enumerator Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->enumeratorRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Enumerator is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Enumerator is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Enumerator Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->enumeratorRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Enumerator is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Enumerator is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return EnumeratorExport
     * @throws Exception
     */
    public function exportEnumerator(array $filters = []): EnumeratorExport
    {
        return (new EnumeratorExport($this->enumeratorRepository->getWith($filters)));
    }
}