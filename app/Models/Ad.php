<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory,UuidTrait;
    protected $table = 'ads';
    protected  $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'description',
        'cost',
        'views_count',
        'category_id',
        'city_id',
        'created_at'
    ];
    public function incrementViewCount() {
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
    public function last_moderator_id()
    {
        $moderation=$this->moderations()->latest()->first();
        if($moderation!=null)
        return  $moderation->user->id;
        else
        return 'null';
    }
}
