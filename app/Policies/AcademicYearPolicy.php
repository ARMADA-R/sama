<?php

namespace App\Policies;

use App\Models\AcademicYear;
use App\Models\ParentAccount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AcademicYearPolicy
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
        return $user->hasPermission('browse-academic-years')
            ? Response::allow()
            : Response::deny(trans('general.You do not have permission to browse academic years.'));
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
        return $user->hasPermission('view-academic-years')
            ? Response::allow()
            : Response::deny('You do not have permission to read academic years information.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-academic-years')
            ? Response::allow()
            : Response::deny('You do not have permission to add new academic years.');
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
        return $user->hasPermission('edit-academic-years')
            ? Response::allow()
            : Response::deny('You do not have permission to edit academic years informations.');
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
        return $user->hasPermission('delete-academic-years')
            ? Response::allow()
            : Response::deny('You do not have permission to delete academic years.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(ParentAccount $parentAccount, AcademicYear $academicYear)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\ParentAccount  $parentAccount
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(ParentAccount $parentAccount, AcademicYear $academicYear)
    {
        //
    }
}
