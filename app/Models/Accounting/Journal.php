<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;


/**
 * App\Models\Accounting\Journal
 *
 * @property int $id
 * @property string $type
 * @property string $code
 * @property string|null $name_ar
 * @property string $name_en
 * @property string|null $description
 * @property int $is_housemaid_financial
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Journal active()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal where($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereIsHousemaidFinancial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Journal extends Model
{
    use HasFactory;
    use HasFilter,  SortableTrait;

    public $sortable = ['*'];
    public static $rules =
        [
            'type' => 'required|in:purchase,employee,partner,other',
            'code' => 'required|unique:journals',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description' => 'nullable|string',
            'is_housemaid_financial' => 'in:1,0',
            'is_active' => 'in:1,0',
        ];
    protected $fillable =
        [
            'name_en',
            'name_ar',
            'code',
            'type',
            'description',
            'is_housemaid_financial',
            'is_active',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_housemaid_financial' => 'boolean',
        'is_active' => 'boolean',
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
