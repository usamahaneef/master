<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements HasMedia , MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable , InteractsWithMedia;

    protected $with = ['profile'];
    protected $hidden = [ 'password', 'profile' , 'media'];
    protected $appends = ['student_profile_url', 'is_profile_complete'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('student_profile_image')->singleFile();
    }
    
    public function profile(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }
    
    public function getStudentProfileUrlAttribute()
    {
        if (!$this->relationLoaded('profile')) {
            $this->load('profile');
        }

        $url = optional($this->profile)->getUrl();
        return $url ? asset($url) : asset('admin/img/avatar-user.png');
    }
    

    public function getNameAttribute()
    {
        if($this->first_name != null)
        {
            $name = $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
            return trim($name);
        }
        return null;
    }

    public function getIsProfileCompleteAttribute()
    {
        return $this->attributes['password'] == null ? false : true;
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'user_id', 'id');
    }

    public function societies(): BelongsToMany
    {
        return $this->belongsToMany(Society::class, 'society_members', 'user_id', 'society_id');
    }

    public function event_subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_subscribers');
    }


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
