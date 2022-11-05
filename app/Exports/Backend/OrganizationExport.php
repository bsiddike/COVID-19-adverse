<?php

namespace App\Exports\Backend;

use App\Abstracts\Export\FastExcelExport;
use App\Models\Organization;
use function config;
use OpenSpout\Common\Exception\InvalidArgumentException;

/**
 * @class OrganizationExport
 */
class OrganizationExport extends FastExcelExport
{
    /**
     * OrganizationExport constructor.
     *
     * @param null $data
     *
     * @throws InvalidArgumentException
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->data($data);
    }

    /**
     * @param Organization $row
     * @return array
     */
    public function map($row): array
    {
        $this->formatRow = [
            '#' => $row->id,
            'Name' => $row->name,
            'Remarks' => $row->remarks,
            'Enabled' => ucfirst($row->enabled),
            'Created' => $row->created_at->format(config('backend.datetime')),
            'Updated' => $row->updated_at->format(config('backend.datetime')),
        ];

        $this->getSupperAdminColumns($row);

        return $this->formatRow;
    }
}
