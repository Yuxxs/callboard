<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    use HasFactory,UuidTrait;
    protected $table = 'moderations';

    public function oldVersion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('Moderation', 'previous_id');
    }



}