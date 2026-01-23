<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'positioning',
        'bio',
        'services',
        'pricing_packs',
        'tech_stack',
        'languages',
    ];

    protected $casts = [
        'services' => AsArrayObject::class,
        'pricing_packs' => AsArrayObject::class,
        'tech_stack' => AsArrayObject::class,
        'languages' => AsArrayObject::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolioItems(): HasMany
    {
        return $this->hasMany(PortfolioItem::class);
    }
}
