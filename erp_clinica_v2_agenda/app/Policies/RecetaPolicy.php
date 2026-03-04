<?php

namespace App\Policies;

use App\Models\Receta;
use App\Models\User;

class RecetaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function view(User $user, Receta $receta): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }

    public function update(User $user, Receta $receta): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }

    public function delete(User $user, Receta $receta): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }
}
