<?php

namespace App\Providers;

use App\Components\RoleDictionary;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Регистрация Gate
        Gate::define('manage-games', function ($user) {
            return in_array($user->role, [RoleDictionary::ADMIN, RoleDictionary::JUDGE]);
        });

    }
}
