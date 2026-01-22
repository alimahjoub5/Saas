<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromptLog extends Model
{
    protected $fillable = [
        'user_id',
        'model',
        'prompt',
        'response',
        'tokens_in',
        'tokens_out',
    ];

    protected $casts = [
        'prompt' => AsArrayObject::class,
        'response' => AsArrayObject::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
