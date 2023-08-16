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

class ApplicationResell extends Model
{
    use HasFactory;
    use HasFilter, SortableTrait;

    public $sortable = ['*'];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'application_id' => 'required|exists:applications,id',
        'sponsor_id' => 'required|exists:sponsors,id',
        'note' => 'nullable|string',
        'status' => 'nullable|in:0,1',
        'resell_date' => 'required|date_format:Y-m-d',
        'sponsor_refund' => 'required',
        'paid_to_sponsor' => 'required|in:0,1',
        'invoice_id' => 'required',
        'invoice_status' => 'required',
        'invoice_amount' => 'required',
        'invoice_due_amount' => 'required',


    ];
    public $fillable = [
        'note',
        'status',
        'application_id',
        'sponsor_id',
        'created_by_id',
        'sponsor_refund',
        'resell_date',
        'paid_to_sponsor',
        'invoice_id',
        'invoice_status',
        'invoice_amount',
        'invoice_due_amount',

    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'string',
        'sponsor_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
        'status' => 'boolean',
        'paid_to_sponsor' => 'boolean',
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
