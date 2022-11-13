<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Symptom extends Model implements Auditable
{
    use AuditableTrait, HasFactory, Sortable;

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'vaers_id', 'vaers_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaers_id', 'vaers_id');
    }


}
