<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Patient extends Model implements Auditable
{
    use AuditableTrait, HasFactory, Sortable;

    public function vaccine()
    {
        return $this->hasOne(Vaccine::class, 'vaers_id', 'vaers_id');
    }

    public function symptom()
    {
        return $this->hasOne(Symptom::class, 'vaers_id', 'vaers_id');
    }
}
