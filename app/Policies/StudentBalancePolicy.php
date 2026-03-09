<?php

namespace App\Policies;

use App\Models\StudentBalance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentBalancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, StudentBalance $studentBalance): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, StudentBalance $studentBalance): bool
    {
    }

    public function delete(User $user, StudentBalance $studentBalance): bool
    {
    }

    public function restore(User $user, StudentBalance $studentBalance): bool
    {
    }

    public function forceDelete(User $user, StudentBalance $studentBalance): bool
    {
    }
}
