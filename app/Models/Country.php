<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UuidTrait;
class Country extends Model
{
    use HasFactory,UuidTrait;
    protected $table ='countries';
}
