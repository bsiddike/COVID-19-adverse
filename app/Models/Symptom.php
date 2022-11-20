<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Symptom extends Model
{
    use Sortable;

    public $timestamps = false;

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'vaers_id', 'vaers_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaers_id', 'vaers_id');
    }
}
