<?php

namespace App\Providers;

use App\Models\CategoryProduct;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        View::composer('website.*', function ($view) {
            $data['auth_user'] = auth()->check() ? auth()->user() : null;
            $data['lang'] = app()->getLocale();
            $data['categories'] = CategoryProduct::query()->get();

            if (isset($data['auth_user']) && !$data['auth_user']->is_active) {
                auth()->logout();
            }

            $view->with($data);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
