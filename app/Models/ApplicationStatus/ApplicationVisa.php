<?php

namespace App\Models\ApplicationStatus;

use App\Models\Application;
use App\Models\Sponsor;
use App\Models\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;


/**
 * Class ApplicationVisa
 * @package App\Models
 * @property string $transaction_date
 * @property string $passport_id
 * @property string $unified_no
 * @property integer $visa_issue_days
 * @property integer $visa_received_days
 * @property string $visa_no
 * @property string $photo
 * @property string $visa_issue_date
 * @property string $visa_expiry_date
 * @property string $visa_received_date
 * @property string $visa_send_date
 * @property string $note
 * @property string $cancellation_date
 * @property boolean $visa_status
 * @property boolean $status
 * @property integer $application_id
 * @property integer $sponsor_id
 * @property integer $created_by_id
 */
class ApplicationVisa extends Model
{

    use HasFilter, SortableTrait;

    public $sortable = ['*'];
    public $table = 'application_visas';


    public $fillable = [
        'transaction_date',
        'sponsor_name_en',
        'sponsor_name_ar',
        'passport_id',
        'visa_issue_days',
        'visa_received_days',

        'visa_no',
        'visa_file_no',
        'photo',
        'visa_issue_date',
        'visa_expiry_date',
        'visa_received_date',
        'visa_send_date',
        'housemaid_unified_no',
        'sponsor_unified_no',
        'sponsor_address_en',
        'sponsor_address_ar',
        'place_of_issue',
        'note',
        'visa_status',
        'status',
        'application_id',
        'sponsor_id',
        'created_by_id',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'string',
        'visa_issue_days' => 'integer',
        'visa_received_days' => 'integer',
        'sponsor_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'application_id' => 'required|exists:applications,id',
        'sponsor_id' => 'required|exists:sponsors,id',

        'transaction_date' => 'required|date_format:Y-m-d',
        'visa_issue_date' => 'required|date_format:Y-m-d',
        'visa_expiry_date' => 'required|date_format:Y-m-d',
        'visa_received_date' => 'required|date_format:Y-m-d',
        'visa_send_date' => 'required|date_format:Y-m-d',

        'note' => 'nullable|string',

        'passport_id' => 'nullable|string',
        'housemaid_unified_no' => 'nullable|string',
        'sponsor_unified_no' => 'nullable|string',
        'visa_no' => 'required|string',
        'visa_file_no' => 'required|string',
        'visa_issue_days' => 'nullable|integer',
        'visa_received_days' => 'nullable|integer',
        'photo' => 'nullable|image',

        'sponsor_name_en' => 'nullable|string',
        'sponsor_name_ar' => 'nullable|string',
        'sponsor_address_en' => 'nullable|string',
        'sponsor_address_ar' => 'nullable|string',
        'place_of_issue' => 'nullable|string',

        'visa_status' => 'nullable|in:visa_send,contract_request,contract_approval,contract_send,return',
        'status' => 'nullable|in:0,1',
    ];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by_id = request()->user()->id;
        });

    }


    /**
     * @return BelongsTo
     **/
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
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
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }


    public function scopeActive($q)
    {
        return $q->where('status', true);
    }


    public function getPhotoAttribute($value)
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
