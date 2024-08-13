<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use App\Models\Permission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            Permission::get()->map(function($permission) {
                Gate::define($permission->slug, function($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });

        } catch(\Exception $e) {
            report($e);
           // return false;
        }

        // create blade directive for role
        Blade::directive('role', function($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) { ?>";
        });

        Blade::directive('endrole', function($role) {
            return "<?php  } ?>";
        });

        // create blade directive for permission
        Blade::directive('permission', function($permission) {
            return "<?php if(auth()->check() && auth()->user()->canany([{$permission}])) { ?>";
        });

        Blade::directive('endpermission', function($permission) {
            return "<?php  } ?>";
        });
    }
}
