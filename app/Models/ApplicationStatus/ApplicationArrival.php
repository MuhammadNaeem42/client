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

class ApplicationArrival extends Model
{
    use HasFactory;

    use HasFilter, SortableTrait;

    public $sortable = ['*'];

    public static $rules = [
        'application_id' => 'required|exists:applications,id',
        'sponsor_id' => 'required|exists:sponsors,id',
        'flight_agent_name' => 'required|string',
        'flight_no' => 'required|string',
        'transaction_date' => 'required|date_format:Y-m-d',
        'arrival_date' => 'required|date_format:Y-m-d',
        'application_email_date' => 'required|date_format:Y-m-d',
        'note' => 'nullable|string',
        'status' => 'nullable|in:0,1',

    ];
    public $fillable = [
        'flight_no',
        'flight_agent_name',
        'sponsor_id',
        'created_by_id',
        'transaction_date',
        'arrival_date',
        'status',
        'application_id',
        'sponsor_id',
        'application_email_date',
    ];
    protected $casts = [
        'note' => 'string',
        'sponsor_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
        'status' => 'boolean',
    ];
    protected $table = 'application_arrivals';

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

    public function getCreatedAtAttribute($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
    }

}
