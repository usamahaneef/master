<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,InteractsWithMedia ;

    protected $with = ['avatar'];
    protected $appends = ['avatar_url'];
    protected $fillable = ['remember_token'];
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }
    
    public function getAvatarUrlAttribute()
    {
        $url = null;
        if ($this->relationLoaded('avatar')) {
            $url = optional($this->avatar)->getUrl();
        }
        return $url ? asset($url): asset('admin/img/avatar.png');
    }

    public function getRoleToDisplayAttribute()
    {
        if ($this->relationLoaded('roles') && !property_exists($this, 'role')) {
            return $this->roles->first()?->name;
        }
        return $this->role;
    }

    public function assignedSocieties(): HasOne
    {
        return $this->hasOne(CustomPermission::class, 'user_id', 'id');
    }

    public function guardName()
    {
        return 'admin';
    }

}
