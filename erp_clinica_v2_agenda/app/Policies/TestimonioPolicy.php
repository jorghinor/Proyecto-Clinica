<?php

namespace App\Policies;

use App\Models\Testimonio;
use App\Models\User;

class TestimonioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user, Testimonio $testimonio): bool
    {
        return $user->hasRole('Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Testimonio $testimonio): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, Testimonio $testimonio): bool
    {
        return $user->hasRole('Admin');
    }
}
