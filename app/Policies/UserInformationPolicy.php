<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserInformationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, UserInformation $userInformation): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, UserInformation $userInformation): bool
    {
    }

    public function delete(User $user, UserInformation $userInformation): bool
    {
    }

    public function restore(User $user, UserInformation $userInformation): bool
    {
    }

    public function forceDelete(User $user, UserInformation $userInformation): bool
    {
    }
}
