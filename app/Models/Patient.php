<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Patient extends Model
{
    use Sortable;

    public $timestamps = false;

    public function vaccine()
    {
        return $this->hasOne(Vaccine::class, 'vaers_id', 'vaers_id');
    }

    public function symptom()
    {
        return $this->hasOne(Symptom::class, 'vaers_id', 'vaers_id');
    }
}
