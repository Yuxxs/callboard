<?php

namespace App\Models;


use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory,UuidTrait;
    protected $table = 'regions';
    protected  $primaryKey = 'id';
    public function cities(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(City::class);
    }
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
