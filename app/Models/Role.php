<?php

namespace App\Models;
use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory,UuidTrait;

    protected $table = 'roles';
    public function permissions(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
    public function users(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(User::class);
    }

}
