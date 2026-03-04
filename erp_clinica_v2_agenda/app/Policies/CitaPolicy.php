<?php

namespace App\Policies;

use App\Models\Cita;
use App\Models\User;

class CitaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function view(User $user, Cita $cita): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function update(User $user, Cita $cita): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function delete(User $user, Cita $cita): bool
    {
        return $user->hasRole('Admin');
    }
}
