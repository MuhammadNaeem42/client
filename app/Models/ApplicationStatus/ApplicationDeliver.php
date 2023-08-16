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

class ApplicationDeliver extends Model
{
    use HasFactory;
    use HasFilter, SortableTrait;

    public $sortable = ['*'];


    public static $rules = [

        'application_id' => 'required|exists:applications,id',
        'sponsor_id' => 'required|exists:sponsors,id',
        'deliver_date' => 'required|date_format:Y-m-d',
        'pay_status' => 'required|in:paid_full,paid_partial',
        'transaction_date' => 'required|date_format:Y-m-d',
        'paid_amount' => 'required|numeric',
        'discount_amount' => 'required|numeric',
        'total' => 'required|numeric',
        'due' => 'required|numeric',
        'note' => 'nullable|string',
        'invoice' => 'nullable',
        'status' => 'nullable|in:0,1',
    ];
    public $table = 'application_delivers';
    public $fillable = [
        'sponsor_id',
        'created_by_id',
        'transaction_date',
        'deliver_date',
        'total',
        'due',
        'paid_amount',
        'discount_amount',
        'status',
        'pay_status',
        'application_id',
        'sponsor_id',
        'invoice',

    ];
    protected $casts = [
        'note' => 'string',
        'sponsor_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
        'status' => 'boolean',
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
