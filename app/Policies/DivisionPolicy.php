<?php

namespace App\Policies;

use App\Models\Division;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DivisionPolicy
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
        return $user->hasPermission('browse-divisions')
            ? Response::allow()
            : Response::deny(trans('general.You do not have permission to browse divisions.'));
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
        return $user->hasPermission('view-divisions')
            ? Response::allow()
            : Response::deny('You do not have permission to read divisions information.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-divisions')
            ? Response::allow()
            : Response::deny('You do not have permission to add new divisions.');
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
        return $user->hasPermission('edit-divisions')
            ? Response::allow()
            : Response::deny('You do not have permission to edit divisions informations.');
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
        return $user->hasPermission('delete-divisions')
            ? Response::allow()
            : Response::deny('You do not have permission to delete divisions.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(ParentAccount $parentAccount, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(ParentAccount $parentAccount, Division $division)
    {
        //
    }
}
