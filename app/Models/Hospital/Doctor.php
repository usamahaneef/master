<?php

namespace App\Models\Hospital;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(DoctorSpeciality::class);
    }
}
