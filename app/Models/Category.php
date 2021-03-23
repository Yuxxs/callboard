<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, UuidTrait;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level'
    ];
    public static function rules($id = null, $merge = []): array
    {
        return array_merge([
            'name' => ['required', 'string', 'max:36'],
            'slug' => ['required', 'string', 'max:36',Rule::unique('categories', 'slug')->ignore($id)],
            'level' =>['int','min:0'],
            'description' => ['string', 'max:200'],
        ],
            $merge);
    }

    public function isRoot(): bool
    {
        return empty($this->parent);
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function ads(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Ad::class);
    }

}
