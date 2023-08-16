<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class ApplicationExternalOfficeTransaction
 * @package App\Models
 *
 */
class ApplicationExternalOfficeTransaction extends Model
{


    public $table = 'application_external_office_transaction';


    public $fillable = [
        'external_office_transaction_id',
        'application_id',
        'created_by_id',
        'date',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'string',
        'date' => 'string',
        'external_office_transaction_id' => 'integer',
        'application_id' => 'integer',
        'created_by_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'application_id' => 'required|exists:applications,id',
        'external_office_transaction_id' => 'required|exists:external_office_transactions,id',
        'date' => 'required|date_format:Y-m-d',
        'note' => 'nullable|string',
    ];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->created_by_id=request()->user()->id;
        });
    }

    /**
     * @return BelongsTo
     **/
    public function external_office_transaction()
    {
        return $this->belongsTo(ExternalOfficeTransaction::class, 'external_office_transaction_id');
    }

    /**
     * @return BelongsTo
     **/
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
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
