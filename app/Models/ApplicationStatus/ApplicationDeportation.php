<?php

namespace App\Models\ApplicationStatus;

use App\Models\Application;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jedrzej\Sortable\SortableTrait;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

class ApplicationDeportation extends Model
{
    use HasFactory;

    use HasFilter, SortableTrait;

    public $sortable = ['*'];

    protected $casts = [
        'note' => 'string',
        'sponsor_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
        'status' => 'boolean',
        'days'=>'integer',
    ];
    public static $rules = [
        'application_id' => 'required|exists:applications,id',
        'sponsor_id' => 'required|exists:sponsors,id',
        'flight_agent_name' => 'required|string',
        'flight_no' => 'required|string',
        'transaction_date' => 'required|date_format:Y-m-d',
        'arrival_date' => 'required|date_format:Y-m-d',
        'application_email_date' => 'required|date_format:Y-m-d',
        'reason' => 'required|string',
        'days'=> 'required|integer',
        'note' => 'nullable|string',
    ];
    public $fillable = [
        'application_id',
        'flight_no',
        'flight_agent_name',
        'application_email_date',
        'arrival_date',
        'transaction_date',
        'reason',
        'days',
        'status',
        'note',
        'sponsor_id',
        'cancellation_date',
        'created_by_id',
        'sponsor_id',

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
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * @return BelongsTo
     **/
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function getCreatedAtAttribute($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }
    public function scopeActive($q)
    {
        return $q->where('status', true);
    }
    /**
     * @return BelongsTo
     **/
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function getUpdatedAtAttribute($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }
}
