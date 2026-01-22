<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    protected $fillable = [
        'user_id',
        'source_id',
        'title',
        'description',
        'budget',
        'skills',
        'platform',
        'url',
        'posted_at',
        'client_country',
        'language',
        'tags',
        'raw_text',
        'dedupe_hash',
        'status',
    ];

    protected $casts = [
        'skills' => AsArrayObject::class,
        'tags' => AsArrayObject::class,
        'posted_at' => 'datetime',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    public function analysis(): HasOne
    {
        return $this->hasOne(LeadAnalysis::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(LeadAttachment::class);
    }
}
