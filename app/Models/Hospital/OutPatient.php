<?php

namespace App\Models\Hospital;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutPatient extends Model
{
    use HasFactory;

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    // public function billing()
    // {
    //     return $this->morphMany(PatientBilling::class, 'patientable');
    // }

}
