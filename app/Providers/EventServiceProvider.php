<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\User; //panggil model User
use App\Observers\UserObserver; //panggil observer UserObserver
use App\Models\Recipe; //panggil model Recipe
use App\Observers\RecipeObserver; //panggil observer RecipeObserver
use App\Models\Tool; //panggil model Tool
use App\Observers\ToolObserver; //panggil observer ToolObserver
use App\Models\Ingredients; //panggil model Ingredients
use App\Observers\IngredientObserver; //panggil observer IngredientObserver


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
        User::observe(UserObserver::class); //registrasikan disini
        Recipe::observe(RecipeObserver::class);
        Tool::observe(ToolObserver::class);
        Ingredients::observe(IngredientObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
