<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $fillable = [
        'lead_id',
        'tone',
        'short_text',
        'medium_text',
        'whatsapp_text',
        'placeholders',
        'status',
    ];

    protected $casts = [
        'placeholders' => AsArrayObject::class,
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
