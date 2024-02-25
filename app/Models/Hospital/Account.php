<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;
    public function head(): BelongsTo
    {
        return $this->belongsTo(AccountHead::class , 'account_head_id' , 'id');
    }
}
