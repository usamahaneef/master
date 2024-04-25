<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPermission extends Model
{
    use HasFactory;

    protected $table = 'custom_permissions';
    protected $fillable = ['permission_id'];
        
    protected $casts = [
        'permission_id' => 'array',
    ];

    public function setEntryPermissionIdAttribute($value)
    {
        $this->attributes['permission_id'] = json_encode($value);
    }

    public function getEntryPermissionIdAttribute($value)
    {
        return json_decode($value, true);
    }
    
}
