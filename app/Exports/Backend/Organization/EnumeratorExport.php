<?php

namespace App\Exports\Backend\Organization;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Backend\Organization\Enumerator;
use Carbon\Carbon;
use OpenSpout\Common\Exception\InvalidArgumentException;

/**
 * @class EnumeratorExport
 */
class EnumeratorExport extends FastExcelExport
{
    /**
     * EnumeratorExport constructor.
     *
     * @param  null  $data
     *
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param  Enumerator  $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            trans('Sl. No.', [], 'en') => $row->counter ?? $row->id,
            trans('Name (English)', [], 'en') => $row->name ?? null,
            trans('Name(Bangla)', [], 'en') => $row->name_bd ?? null,
            trans('Gender', [], 'en') => $row->gender->name ?? null,
            trans('Date of Birth', [], 'en') => isset($row) ? Carbon::parse($row->dob)->format('d/m/Y') : null,
            trans('Age (years)', [], 'en') => isset($row) ? Carbon::parse($row->dob)->age : null,
            trans('Father\'s Name', [], 'en') => $row->father ?? null,
            trans('Mother\' Name', [], 'en') => $row->mother ?? null,
            trans('NID Number', [], 'en') => $row->nid ?? null,
            trans('Present Address', [], 'en') => $row->present_address ?? null,
            trans('Permanent Address', [], 'en') => $row->permanent_address ?? null,
            trans('Education', [], 'en') => $row->examLevel->name ?? null,
            trans('Mobile 1', [], 'en') => $row->mobile_1 ?? null,
            trans('Mobile 2', [], 'en') => $row->mobile_2 ?? null,
            trans('Email', [], 'en') => $row->email ?? null,
            trans('Whatsapp Number', [], 'en') => $row->whatsapp ?? null,
            trans('Facebook ID', [], 'en') => $row->facebook ?? null,
        ];

        $this->formatRow[trans('Revenue staff of BBS', [], 'en')] = ucfirst($row->is_employee) ?? null;
        $this->formatRow[trans('Designation', [], 'en')] = (($row->is_employee == 'yes') ? $row->designation : 'N/A') ?? null;
        $this->formatRow[trans('Office Name', [], 'en')] = (($row->is_employee == 'yes') ? $row->company : 'N/A') ?? null;

        //if(is_null(request('prev_post_state_id'))){
        $this->formatRow = array_merge($this->formatRow, [
            trans('Worked Earlier', [], 'en') => $this->stateArrayToString($row->previousPostings) ?? null,
        ]);
        //}
        //if(is_null(request('future_post_state_id'))){
        $this->formatRow = array_merge($this->formatRow, [
            trans('Want to work in future', [], 'en') => $this->stateArrayToString($row->futurePostings) ?? null,
        ]);
        //}
        //if(is_null(request('survey_id'))){
        $this->formatRow = array_merge($this->formatRow, [
            trans('Work Experience in BBS', [], 'en') => $this->surveys($row->surveys) ?? null,
        ]);
        //}
        if (request('is_total_survey') == true) {
            $this->formatRow = array_merge($this->formatRow, [
                trans('Total Survey', [], 'en') => $row->totalSurvey ?? null,
            ]);
        }
        $this->formatRow = array_merge($this->formatRow, [
            trans('Created By', [], 'en') => $row->created_by_username ?? 'null',
            //'Enabled' => ucfirst(($row->enabled ?? '')),
            'Created Date' => $row->created_at->format(config('backend.datetime')),
        ]);

        /*$this->getSupperAdminColumns($row);*/

        if (request('filter') == 'survey') {
            unset($this->formatRow[trans('Father\'s Name', [], 'en')]);
            unset($this->formatRow[trans('Mother\' Name', [], 'en')]);
            unset($this->formatRow[trans('Permanent Address', [], 'en')]);
            unset($this->formatRow[trans('Education', [], 'en')]);
            unset($this->formatRow[trans('Mobile 2', [], 'en')]);
            unset($this->formatRow[trans('Revenue staff of BBS', [], 'en')]);
            unset($this->formatRow[trans('Designation', [], 'en')]);
            unset($this->formatRow[trans('Office Name', [], 'en')]);
            unset($this->formatRow[trans('Want to work in future', [], 'en')]);
            unset($this->formatRow[trans('Worked Earlier', [], 'en')]);
            unset($this->formatRow[trans('Created By', [], 'en')]);
            unset($this->formatRow['Created Date']);
        }

        return $this->formatRow;
    }

    /**
     * @param $data
     * @return string
     */
    public function stateArrayToString($data): string
    {
        $stateArray = [];
        $stateString = 'No District Available';
        if (isset($data)) {
            foreach ($data as $index => $state) {
                $stateArray[] = ($index + 1).'. '.$state->name ?? null."\n";
            }
            $stateString = implode("\n", $stateArray);
        }

        return $stateString;
    }

    /**
     * @param $data
     * @return string
     */
    public function surveys($data): string
    {
        $stateArray = [];
        $stateString = 'No Survey Available';
        if (isset($data)) {
            foreach ($data as $index => $survey) {
                $stateArray[] = ($index + 1).'. '.$survey->name ?? null."\n";
            }
            $stateString = implode("\n", $stateArray);
        }

        return $stateString;
    }
}
