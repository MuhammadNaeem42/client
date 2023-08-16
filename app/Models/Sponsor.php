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

/**
 * Class Sponsor
 * @package App\Models
 *
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property string $civil_id
 * @property string $email
 * @property string $mobile
 * @property string $phone
 * @property string $password
 * @property string $link
 * @property boolean $is_block
 * @property boolean $is_active
 */
class Sponsor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFilter, SortableTrait;

    public $sortable = ['*'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'civil_id',
        'email',
        'mobile',
        'password',
        'phone',
        'language',
        'gender',
        'photo',

        'front_civil_photo',//from civil_photo
        'back_civil_photo',
        'blood_type',
        'expire_date_civil_card',
        'birth_date',

        ### start address info ###
        'unit_type',
        'area',
        'block',
        'street',
        'unit_no',
        'floor',
        'building_no',
        'serial_no',
        'paci_unit_no',
        'shipping_email',
        'phones',//multi list
        ### end address info ###

        'job_position',
        'work_attachments',


        'device_token',
        'country_id',
        'job_id',
        'created_by_id',
        'is_active',
        'is_block',
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
        'name_en' => 'required|min:2|max:191',
        'name_ar' => 'nullable|min:2|max:191',
        'address_en' => 'nullable',
        'address_ar' => 'nullable',
        'civil_id' => 'nullable|unique:sponsors',
        'email' => 'nullable|email|min:3|max:255|unique:sponsors',
        'mobile' => 'required|min:3|max:255|unique:sponsors',
        'password' => 'nullable|min:6',
        'phone' => 'nullable',
        'language' => 'nullable|in:english,arabic',
        'gender' => 'nullable|in:male,female',
        'photo' => 'nullable',
        'front_civil_photo' => 'nullable',
        'back_civil_photo' => 'nullable',
        'blood_type' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
        'expire_date_civil_card' => 'nullable|date_format:Y-m-d',
        'birth_date' => 'nullable|date_format:Y-m-d',

        'unit_type' => 'nullable',
        'area' => 'nullable',
        'block' => 'nullable',
        'street' => 'nullable',
        'unit_no' => 'nullable',
        'floor' => 'nullable',
        'building_no' => 'nullable',
        'serial_no' => 'nullable',
        'paci_unit_no' => 'nullable',
        'shipping_email' => 'nullable|email',
        'phones' => 'nullable|array|min:1',
        'phones.*' => 'required',

        'job_position' => 'nullable',
        'work_attachments' => 'nullable|array',
        'work_attachments.*' => 'file',

        'device_token' => 'nullable',
        'country_id' => 'nullable|exists:countries,id',
        'job_id' => 'nullable|exists:jobs,id',
        'is_block' => 'in:1,0',
        'is_active' => 'in:1,0',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile' => 'string',
        'phone' => 'string',
        'phones' => Json::class,
        'civil_photo' => 'string',
        'country_id' => 'integer',
        'job_id' => 'integer',
        'is_block' => 'boolean',
        'is_active' => 'boolean',
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
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function scopeBlocked($q)
    {
        return $q->where('is_block', 1);
    }

//    public function setPhonesAttribute($value)
//    {
//        return json_encode($value);
//    }
//
//    public function getPhonesAttribute($value)
//    {
//        return json_decode($value);
//    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getFrontCivilPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
    public function getBackCivilPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }

}
