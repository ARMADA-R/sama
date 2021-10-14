<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\Division;
use App\Models\Level;
use App\Models\Role;
use App\Models\Semester;
use App\Models\Stage;
use App\Models\User;
use App\Policies\AcademicYearPolicy;
use App\Policies\DivisionPolicy;
use App\Policies\LevelPolicy;
use App\Policies\RolePolicy;
use App\Policies\SemesterPolicy;
use App\Policies\StagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Division::class => DivisionPolicy::class,
        Level::class => LevelPolicy::class,
        Semester::class => SemesterPolicy::class,
        Stage::class => StagePolicy::class,
        AcademicYear::class => AcademicYearPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
