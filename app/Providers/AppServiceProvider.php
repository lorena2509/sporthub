<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            app()->instance(\Illuminate\Contracts\Http\Kernel::class, new class extends \App\Http\Kernel {
                protected $middleware = [
                    // Aquí puedes omitir VerifyCsrfToken si solo quieres desactivarlo en testing
                ];
            });
        }
            }
}
