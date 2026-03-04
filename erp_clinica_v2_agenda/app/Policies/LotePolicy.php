<?php

namespace App\Policies;

use App\Models\Lote;
use App\Models\User;

class LotePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function view(User $user, Lote $lote): bool
    {
        return $user->hasRole(['Admin', 'Medico', 'Recepcionista']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Lote $lote): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, Lote $lote): bool
    {
        return $user->hasRole('Admin');
    }
}
