<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Vaccine extends Model
{
    use Sortable;

    public $timestamps = false;

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'vaers_id', 'vaers_id');
    }

    public function symptom()
    {
        return $this->hasOne(Symptom::class, 'vaers_id', 'vaers_id');
    }
}
