<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Vaccine extends Model
{
    use Sortable;

    public $timestamps = false;

}
