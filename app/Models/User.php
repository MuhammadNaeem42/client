<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jedrzej\Sortable\SortableTrait;
use Laravel\Sanctum\HasApiTokens;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFilter, SortableTrait;
    static $USER_TYPE_INTERNAL_OFFICE = 'internal_office';
    static $USER_TYPE_EXTERNAL_OFFICE = 'external_office';
    static $USER_TYPE_USER = 'user';

    public $sortable = ['*'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'type',
        'role',
        'model_id',
        'photo',
        'model_type',
        'all_permissions',
        'current_permissions',
        'is_active',
        'signature',
        'language_id',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email|min:3|max:255|unique:users',
        'mobile' => 'required|min:3|max:255|unique:users',
        'password' => 'required|min:6',
        'type' => 'required|in:internal_office,external_office,user',
        'role' => 'required|in:admin,employee',
        'device_token' => 'nullable',
        'all_permissions' => 'nullable|array',
        'current_permissions' => 'nullable|array',
        'language_id' => 'nullable|exists:languages,id',
        'signature' => 'nullable',
        'country_id' => 'nullable|exists:countries,id',
        'model_id' => 'required_if:type,internal_office,external_office',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'all_permissions' => Json::class,
        'current_permissions' => Json::class,
        'model_id' => 'integer',
        'language_id' => 'integer',
        'country_id' => 'integer'
    ];

    /**
     * @return BelongsTo
     **/
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    /**
     * @return BelongsTo
     **/
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }


    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }


}
