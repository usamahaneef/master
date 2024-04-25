<?php
namespace App\Models\Overides;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Permission\Models\Role as baseRole;

class Role extends baseRole
{

    const SUPER_ADMIN = "SuperAdmin";
    public function __construct(array $attributes = [])
    {
        $attributes['roleable_id'] = $attributes['roleable_id'] ?? auth()->user()?->id;
        $attributes['roleable_type'] = $attributes['roleable_type'] ?? auth()->user()?->getMorphClass();

        parent::__construct($attributes);
    }

    public function scopeWithoutSuperAdmin(Builder $builder)
    {
        return $builder->where('name', '!=', self::SUPER_ADMIN);
    }


    public function roleable(): MorphTo
    {
        return $this->morphTo();
    }
}
