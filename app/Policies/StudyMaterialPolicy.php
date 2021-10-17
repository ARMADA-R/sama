<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudyMaterial;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StudyMaterialPolicy
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
        return $user->hasPermission('browse-study-materials')
            ? Response::allow()
            : Response::deny(trans('general.You do not have permission to browse study materials.'));
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
        return $user->hasPermission('view-study-materials')
            ? Response::allow()
            : Response::deny('You do not have permission to read study materials information.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-study-materials')
            ? Response::allow()
            : Response::deny('You do not have permission to add new study materials.');
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
        return $user->hasPermission('edit-study-materials')
            ? Response::allow()
            : Response::deny('You do not have permission to edit study materials informations.');
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
        return $user->hasPermission('delete-study-materials')
            ? Response::allow()
            : Response::deny('You do not have permission to delete study materials.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\StudyMaterial  $studyMaterial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(ParentAccount $parentAccount, StudyMaterial $studyMaterial)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\StudyMaterial  $studyMaterial
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(ParentAccount $parentAccount, StudyMaterial $studyMaterial)
    {
        //
    }
}
