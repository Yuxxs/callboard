<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdStatus extends Model
{
    use HasFactory,UuidTrait;
    public function ads(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Ad::class);
    }
}
