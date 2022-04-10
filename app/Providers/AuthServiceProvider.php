<?php

namespace App\Providers;

use App\Models\Library;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('can-studying-words', function (User $user, int $libraryId) {

            return Library::query()
                ->where('user_id', $user->id)
                ->where('id', $libraryId)
                ->get()
                ->isNotEmpty();
        });


        Gate::define('can-edit-library', function (User $user, int $libraryId) {

            return Library::query()
                ->where('user_id', $user->id)
                ->where('id', $libraryId)
                ->get()
                ->isNotEmpty();
        });

    }
}
