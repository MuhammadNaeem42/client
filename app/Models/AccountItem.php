<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class AccountItem
 * @package App\Models
 *
 * @property string $name
 * @property boolean $is_active
 */
class AccountItem extends Model
{


    public $table = 'account_items';




    public $fillable = [
        'name_en',
        'name_ar',

        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name_en' => 'string',
        'name_ar' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name_en' => 'required|min:2|max:191',
        'name_ar' => 'nullable|min:2|max:191',
        'is_active' => 'in:1,0',
    ];

    /**
     * @param $q
     * @return mixed
     */
    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
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
