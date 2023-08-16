<?php

namespace App\Models;

use App\StateMachines\StatusStateApplication;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;


/**
 * Class ExternalOffice
 * @package App\Models
 *
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property string $code
 * @property string $phone
 * @property double $commission
 * @property integer $country_id
 * @property integer $currency_id
 * @property boolean $is_active
 * @method static find(mixed $external_office_id)
 */
class ExternalOffice extends Model
{

    use HasFilter, SortableTrait;

    public $sortable = ['*'];
    public $table = 'external_offices';


    public $fillable = [
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'code',
        'phone',
        'commission',

        'bank_info_name',
        'bank_info_company_name',
        'bank_info_beneficiary_name',
        'bank_info_country_id',
        'bank_info_currency_id',
        'bank_info_swift_code',
        'bank_info_iban',
        'bank_info_account_number',
        'bank_info_phone',

        'country_id',
        'currency_id',
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
        'address_en' => 'string',
        'address_ar' => 'string',
        'code' => 'string',
        'phone' => 'string',
        'commission' => 'double',
        'country_id' => 'integer',
        'bank_info_country_id' => 'integer',
        'currency_id' => 'integer',
        'bank_info_currency_id' => 'integer',
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
        'address_en' => 'nullable',
        'address_ar' => 'nullable',
        'phone' => 'nullable',
        'commission' => 'required|numeric',
        'country_id' => 'required|exists:countries,id',
        'currency_id' => 'required|exists:currencies,id',
        'bank_info_name' => 'nullable',
        'bank_info_company_name' => 'nullable',
        'bank_info_beneficiary_name' => 'nullable',
        'bank_info_swift_code' => 'nullable',
        'bank_info_iban' => 'nullable',
        'bank_info_account_number' => 'nullable',
        'bank_info_phone' => 'nullable',
        'bank_info_country_id' => 'nullable|exists:countries,id',
        'bank_info_currency_id' => 'nullable|exists:currencies,id',
        'code' => 'required|min:2|max:191|unique:external_offices',
        'is_active' => 'in:1,0',
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
    public function bank_info_country()
    {
        return $this->belongsTo(Country::class, 'bank_info_country_id');
    }

    /**
     * @return BelongsTo
     **/
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * @return BelongsTo
     **/
    public function bank_info_currency()
    {
        return $this->belongsTo(Currency::class, 'bank_info_currency_id');
    }


    public function internal_offices()
    {
        return $this->belongsToMany(InternalOffice::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'external_office_id');
    }
    public function applications_done()
    {
        return $this->applications()
            ->where('status',StatusStateApplication::SELL_AS_FINAL);
    }
    public function applications_cancel()
    {
        return $this->applications()
            ->where('status',StatusStateApplication::CANCEL_APPLICATION);
    }

    public  function getStatistics(){
        $res = $this->applications()
            ->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        $states = StatusStateApplication::STATES;
        $list_states = collect($states)->mapWithKeys(function ($item, $key) use ($res) {
            $total = 0;
            if ($exists_status = collect($res)->firstWhere('status', '=', $item)) {
                $total = $exists_status->total;
            }
            return [$item => $total];
        })->toArray();

        return $list_states;
    }

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
