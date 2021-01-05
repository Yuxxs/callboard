<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,UuidTrait;
    protected $table = 'categories';

    public function parent()
    {
        return $this->belongsTo('Category', 'parent_id');
    }

    public $timestamps = false;

}
