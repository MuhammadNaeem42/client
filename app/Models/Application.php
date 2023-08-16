<?php

namespace App\Models;

use App\Models\ApplicationStatus\ApplicationArrival;
use App\Models\ApplicationStatus\ApplicationDeliver;
use App\Models\ApplicationStatus\ApplicationDeportation;
use App\Models\ApplicationStatus\ApplicationExpectedArrival;
use App\Models\ApplicationStatus\ApplicationResell;
use App\Models\ApplicationStatus\ApplicationReservation;
use App\Models\ApplicationStatus\ApplicationVisa;
use App\StateMachines\StatusStateApplication;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;


/**
 * Class Application
 * @package App\Models
 *
 * @property string $code
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property integer $age
 * @property string $birth_date
 * @property string $gender
 * @property string $marital_status
 * @property integer $kids_no
 * @property string $photo
 * @property string $full_body_photo
 * @property double $housemaid_price
 * @property double $salary
 * @property double $office_commission
 * @property integer $currency_id
 * @property integer $external_office_id
 * @property integer $internal_office_id
 * @property integer $sponsor_id
 * @property string $passport_no
 * @property string $passport_issue_date
 * @property string $passport_expiry_date
 * @property string $place_birth
 * @property integer $country_id
 * @property string $english_skills
 * @property string $arabic_skills
 * @property string $experience
 * @property string $experience_details
 * @property integer $job_id
 * @property integer $religion_id
 * @property integer $education_id
 * @property integer $created_by_id
 * @property integer $responsible_user_id
 */
class Application extends Model
{
    use  HasFactory;
    use HasStateMachines;
    use HasFilter, SortableTrait;

    public $sortable = ['*'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|min:2|max:191|unique:applications',
        'name_en' => 'required|min:2|max:191',
        'name_ar' => 'nullable|min:2|max:191',
        'address_en' => 'nullable',
        'address_ar' => 'nullable',
        'age' => 'required|integer',
        'birth_date' => 'required|date_format:Y-m-d',
        'gender' => 'required|in:male,female',
        'marital_status' => 'required|in:single,married,widower,divorced',
        'kids_no' => 'integer|min:0',
        'photo' => 'nullable',
        'full_body_photo' => 'nullable',

        'housemaid_price' => 'required|numeric|digits_between:1,10',
        'salary' => 'required|numeric|digits_between:1,10',
        'external_office_id' => 'required|exists:external_offices,id', //required validation if is super admin
        'internal_office_id' => 'required|exists:internal_offices,id',
        'sponsor_id' => 'nullable|exists:sponsors,id', //not required but required in Reservation

        'passport_no' => 'required',
        'passport_issue_date' => 'required|date_format:Y-m-d',
        'passport_expiry_date' => 'required|date_format:Y-m-d',
        'place_birth' => 'required',
        'country_id' => 'required|exists:countries,id',

        'english_skills' => 'required|in:excellent,good,poor',
        'arabic_skills' => 'required|in:excellent,good,poor',
        'experience' => 'required',
        'experience_details' => 'required',
        'job_id' => 'required|exists:jobs,id',
        'religion_id' => 'required|exists:religions,id',
        'education_id' => 'required|exists:educations,id',
        'responsible_user_id' => 'nullable|exists:users,id',

        'application_external_office_transactions.*' => 'nullable|array|min:1',
        'application_external_office_transactions.*.id' => 'required|exists:external_office_transactions,id',
        'application_external_office_transactions.*.date' => 'required|date_format:Y-m-d',
        'application_external_office_transactions.*.note' => 'nullable|string',


    ];
    public $stateMachines = [
        'status' => StatusStateApplication::class,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        /* start personal info*/
        'code',
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'age',
        'birth_date',
        'gender',
        'marital_status',
        'kids_no',
        'photo',
        'full_body_photo',
        'housemaid_price',
        'salary',
        'office_commission',
        'currency_id',
        'external_office_id',
        'internal_office_id',
        'sponsor_id',

        /* start passport info*/
        'passport_no',
        'passport_issue_date',
        'passport_expiry_date',
        'place_birth',
        'country_id',

        /* start skills info*/
        'english_skills',
        'arabic_skills',
        'experience',
        'experience_details',
        'job_id',
        'religion_id',
        'education_id',

        /* start system info*/
        'created_by_id',
        'responsible_user_id',

    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => 'integer',
        'kids_no' => 'integer',
        'housemaid_price' => 'double',
        'salary' => 'double',
        'office_commission' => 'double',
        'external_office_id' => 'integer',
        'internal_office_id' => 'integer',
        'currency_id' => 'integer',
        'sponsor_id' => 'integer',
        'country_id' => 'integer',
        'job_id' => 'integer',
        'religion_id' => 'integer',
        'education_id' => 'integer',
        'created_by_id' => 'integer',
        'responsible_user_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function external_office_transactions()
    {
        return $this->belongsToMany(ExternalOfficeTransaction::class)
            ->withPivot('note', 'date', 'created_by_id')
            ->withTimestamps();
    }

    /**
     * @return BelongsTo
     **/
    public function external_office()
    {
        return $this->belongsTo(ExternalOffice::class, 'external_office_id');
    }

    /**
     * @return BelongsTo
     **/
    public function internal_office()
    {
        return $this->belongsTo(InternalOffice::class, 'internal_office_id');
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
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * @return BelongsTo
     **/
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
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
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    /**
     * @return BelongsTo
     **/
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    /**
     * @return HasOne
     **/
    public function reservation()
    {
        return $this->hasOne(ApplicationReservation::class, 'application_id')
            ->where('status', true);
    }

    /**
     * @return HasOne
     **/
    public function visa()
    {
        return $this->hasOne(ApplicationVisa::class, 'application_id')
            ->where('status', true);
    }

    public function expectedArrival(): HasOne
    {
        return $this->hasOne(ApplicationExpectedArrival::class, 'application_id')
            ->where('status', true);
    }

    public function arrival(): HasOne
    {
        return $this->hasOne(ApplicationArrival::class, 'application_id')
            ->where('status', true);
    }

    public function deportation(): HasOne
    {
        return $this->hasOne(ApplicationDeportation::class, 'application_id')
            ->where('status', true);
    }

    public function deliver(): HasOne
    {
        return $this->hasOne(ApplicationDeliver::class, 'application_id')
            ->where('status', true);
    }

    public function resell(): HasOne
    {
        return $this->hasOne(ApplicationResell::class, 'application_id')
            ->where('status', true);
    }

    /**
     * @return BelongsTo
     **/
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * @return BelongsTo
     **/
    public function responsible_user()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }


    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getFullBodyPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i');
    }

    public function scopeActive($q)
    {
        return $q->where('status', true);
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // you can do the same thing using anonymous function
        // let's add another scope using anonymous function
        static::addGlobalScope('owner', function (Builder $builder) {
            $user = request()->user();
            // dd($user, request()->user());
            if ($user) {
                if ($user->type == User::$USER_TYPE_EXTERNAL_OFFICE)
                    $builder->where('external_office_id', $user->model_id);
                elseif ($user->type == User::$USER_TYPE_INTERNAL_OFFICE)
                    $builder->where('internal_office_id', $user->model_id);
            }


        });
    }
}
