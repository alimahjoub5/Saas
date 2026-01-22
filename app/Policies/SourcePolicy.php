<?php

namespace App\Policies;

use App\Models\LeadSource;
use App\Models\User;

class SourcePolicy
{
    public function view(User $user, LeadSource $source): bool
    {
        return $source->user_id === $user->id;
    }
}
