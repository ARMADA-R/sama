<?php

namespace App\Policies;

use App\Models\Level;
use App\Models\ParentAccount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LevelPolicy
{
    use HandlesAuthorization;

        
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('browse-levels')
            ? Response::allow()
            : Response::deny(trans('general.You do not have permission to browse levels.'));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-levels')
            ? Response::allow()
            : Response::deny('You do not have permission to read levels information.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-levels')
            ? Response::allow()
            : Response::deny('You do not have permission to add new levels.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('edit-levels')
            ? Response::allow()
            : Response::deny('You do not have permission to edit levels informations.');
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-levels')
            ? Response::allow()
            : Response::deny('You do not have permission to delete levels.');
    }


    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(ParentAccount $parentAccount, Level $level)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(ParentAccount $parentAccount, Level $level)
    {
        //
    }
}
