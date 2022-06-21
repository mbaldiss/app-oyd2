<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // solicitor
    public function add(User $user)
    {
        return $user->role == 'solicitor'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
    public function save(User $user)
    {
        return $user->role == 'solicitor'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
    public function delete(User $user)
    {
        return $user->role == 'solicitor'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
    public function show(User $user)
    {
        return $user->role == 'solicitor'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
    public function update(User $user)
    {
        return $user->role == 'solicitor'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }

    // authorizer
    public function create(User $user)
    {
        return $user->role == 'authorizer'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
    public function finalize(User $user)
    {
        return $user->role == 'authorizer'
                ? Response::allow()
                : Response::deny('You do not have permission to perform this action.');
    }
}
