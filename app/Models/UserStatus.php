<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory,UuidTrait;
    public function users(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class);
    }
}
