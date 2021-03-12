<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'middlename',
        'surname',
        'phone',
        'phone_calls_time',
        'email',
        'password',
    ];

    public static function rules($id = null, $merge = []): array
    {
        return array_merge([
            'name' => ['required', 'string', 'max:60'],
            'surname' => ['required', 'string', 'max:60'],
            'middlename' => ['required', 'string', 'max:60'],
            'phone_calls_time' => ['required', 'string', 'max:300'],
            'phone' => ['required', 'string', 'max:16', Rule::unique('users', 'phone')->ignore($id), 'regex:/(8)[0-9]{10}/'],
            'email' => ['required', 'string', 'email', 'max:60', Rule::unique('users', 'email')->ignore($id)],
            'password' => ['required', 'string', 'max:60','min:8'],
        ],
            $merge);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserStatus::class, 'status_id');
    }

    public function ads(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function moderations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Moderation::class);
    }
}
