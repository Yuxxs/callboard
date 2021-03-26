<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Ad extends Model
{
    use HasFactory,UuidTrait,SoftDeletes;
    protected $table = 'ads';
    protected  $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'cost',
    ];
    public static function rules($merge = []): array
    {
        return array_merge([
            'name' => ['required', 'string', 'max:36'],
            'description' => ['required', 'string', 'max:200'],
            'cost' =>['required','int','min:0'],
            'images'=>['required','array','max:10'],
            'images.*' => ['image','mimes:jpeg,png,jpg,svg'],
        ],
            $merge);
    }
    public function incrementViewCount(): bool
    {
        $this->views_count++;
        return $this->save();
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdStatus::class);
    }
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function moderations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Moderation::class);
    }
    public function last_moderator()
    {
       return $this->moderations()->latest()->first();
    }
}
