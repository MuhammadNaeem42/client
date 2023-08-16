<?php

namespace App\Models;

use Eloquent as Model;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;


/**
 * Class Currency
 * @package App\Models
 *
 * @property string $name_en
 * @property string $name_ar
 * @property string $symbol
 * @property string $unit
 * @property string $sub_unit
 * @property string $rate
 * @property boolean $is_active
 */
class Currency extends Model
{

    use HasFilter,  SortableTrait;

    public $sortable = ['*'];
    public $table = 'currencies';


    public $fillable = [
        'name_en',
        'name_ar',
        'symbol',
        'unit',
        'sub_unit',
        'rate',
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
        'rate' => 'double',
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
        'symbol' => 'required|min:1|max:191',
        'rate' => 'numeric',
        'is_active' => 'in:1,0',
    ];

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
