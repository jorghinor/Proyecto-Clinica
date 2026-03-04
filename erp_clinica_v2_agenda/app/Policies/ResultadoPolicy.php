<?php

namespace App\Policies;

use App\Models\Resultado;
use App\Models\User;

class ResultadoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function view(User $user, Resultado $resultado): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }

    public function update(User $user, Resultado $resultado): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }

    public function delete(User $user, Resultado $resultado): bool
    {
        return $user->hasRole(['Admin', 'Medico']);
    }
}
