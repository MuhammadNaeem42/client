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
 * Class ApplicationReservation
 * @package App\Models
 * @property string $passport_id
 * @property integer $reservation_days
 * @property string $reservation_date
 * @property string $pay_due_date
 * @property double $deal_amount
 * @property double $down_payment_amount
 * @property boolean $paid_immediately
 * @property boolean $status
 * @property integer $application_id
 * @property integer $sponsor_id
 * @property integer $invoice_sales_id
 * @property integer $created_by_id
 */
class ApplicationReservation extends Model
{

    use HasFilter, SortableTrait;

    public $sortable = ['*'];

    public $table = 'application_reservations';


    public $fillable = [
        'passport_id',
        'reservation_days',
        'reservation_date',
        'pay_due_date',
        'deal_amount',
        'down_payment_amount',
        'paid_immediately',
        'status',
        'date',
        'note',
        'application_id',
        'sponsor_id',
        'invoice_sales_id',
        'created_by_id',
        'cancellation_date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'string',
        'reservation_date' => 'string',
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
        'reservation_date' => 'required|date_format:Y-m-d',
        'pay_due_date' => 'required_if:paid_immediately,0|date_format:Y-m-d',
        'note' => 'nullable|string',
        'passport_id' => 'nullable|string',
        'reservation_days' => 'nullable|integer',
        'deal_amount' => 'required|numeric|min:1',
        'down_payment_amount' => 'required|numeric|min:0|lte:deal_amount',
        'status' => 'nullable|in:0,1',
        'paid_immediately' => 'in:0,1',
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


    public function getCancellationDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
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
