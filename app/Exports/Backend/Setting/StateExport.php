<?php

namespace App\Exports\Backend\Setting;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Setting\Role;
use function config;
use OpenSpout\Common\Exception\InvalidArgumentException;

class StateExport extends FastExcelExport
{
    /**
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
     * @param  Role  $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Display Name' => $row->name,
            'Guard' => ucfirst($row->guard_name),
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('backend.datetime')),
            'Updated' => $row->updated_at->format(config('backend.datetime')),
        ];

        $this->getSupperAdminColumns($row);

        return $this->formatRow;
    }
}
