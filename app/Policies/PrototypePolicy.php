<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Prototype;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrototypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //

        return in_array("View prototype", $user->simplePermissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prototype  $prototype
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Prototype $prototype)
    {
        //
        return in_array("View prototype", $user->simplePermissions);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return in_array("Create prototype", $user->simplePermissions);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prototype  $prototype
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Prototype $prototype)
    {
        //
        return in_array("Edit prototype", $user->simplePermissions);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prototype  $prototype
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Prototype $prototype)
    {
        //
        return in_array("Delete prototype", $user->simplePermissions);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prototype  $prototype
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Prototype $prototype)
    {
        //
        return in_array("Delete prototype", $user->simplePermissions);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Prototype  $prototype
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Prototype $prototype)
    {
        //
        return in_array("Delete prototype", $user->simplePermissions);
    }
}
