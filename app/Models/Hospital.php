<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Hospital extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function guardName()
    {
        return 'hospital';
    }
}
