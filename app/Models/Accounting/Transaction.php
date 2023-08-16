<?php

namespace App\Models\Accounting;

use App\Models\Application;
use App\Models\ExternalOffice;
use App\Models\InternalOffice;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

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

    public function externalOffice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExternalOffice::class, 'external_office_id');
    }

    public function internalOffice(): BelongsTo
    {
        return $this->belongsTo(InternalOffice::class, 'internal_office_id');
    }
}
