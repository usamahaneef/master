<?php

use App\Models\Hospital\Doctor;

function loggedInHospital()
{
    return auth()->user('hospital');
}

function loggedInHospitalDoctor()
{
    return Doctor::whereHospitalId(loggedInHospital()->id)->get();
}

// function incrementRefIndex(): void
// {
//     $refIndex = loggedInHospital()->configs()->where('key', 'announcement_ref_index')->first();
//     $refIndex->value = intval($refIndex->value) + 1;
//     $refIndex->save();
// }

