<?php

namespace App\Policies;

use App\Models\Medico;
use App\Models\User;

class MedicoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function view(User $user, Medico $medico): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Medico $medico): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, Medico $medico): bool
    {
        return $user->hasRole('Admin');
    }
}
