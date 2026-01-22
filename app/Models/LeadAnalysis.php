<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAnalysis extends Model
{
    protected $fillable = [
        'lead_id',
        'summary',
        'skills',
        'language',
        'red_flags',
        'scoring',
        'prompt_log_id',
    ];

    protected $casts = [
        'summary' => AsArrayObject::class,
        'skills' => AsArrayObject::class,
        'red_flags' => AsArrayObject::class,
        'scoring' => AsArrayObject::class,
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function promptLog(): BelongsTo
    {
        return $this->belongsTo(PromptLog::class);
    }
}
