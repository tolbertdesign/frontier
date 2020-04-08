<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Pledge;
use Illuminate\Auth\Access\HandlesAuthorization;

class PledgePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pledges.
     *
     * @param  \App\Entities\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the pledge.
     *
     * @param  \App\Entities\User  $user
     * @param  \App\Entities\Pledge  $pledge
     * @return mixed
     */
    public function view(User $user, Pledge $pledge)
    {
        //
    }

    /**
     * Determine whether the user can create pledges.
     *
     * @param  \App\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the pledge.
     *
     * @param  \App\Entities\User  $user
     * @param  \App\Entities\Pledge  $pledge
     * @return mixed
     */
    public function update(User $user, Pledge $pledge)
    {
        $parents = $pledge->participantUser->parents()->get()->pluck('id');
        return $parents->contains($user->id);
    }

    /**
     * Determine whether the user can delete the pledge.
     *
     * @param  \App\Entities\User  $user
     * @param  \App\Entities\Pledge  $pledge
     * @return mixed
     */
    public function delete(User $user, Pledge $pledge)
    {
        $parents = $pledge->participantUser->parents->get()->pluck('id');
        return $parents->contains($user->id);
    }

    /**
     * Determine whether the user can restore the pledge.
     *
     * @param  \App\Entities\User  $user
     * @param  \App\Entities\Pledge  $pledge
     * @return mixed
     */
    public function restore(User $user, Pledge $pledge)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the pledge.
     *
     * @param  \App\Entities\User  $user
     * @param  \App\Entities\Pledge  $pledge
     * @return mixed
     */
    public function forceDelete(User $user, Pledge $pledge)
    {
        //
    }
}
