<?php

namespace BrianFaust\Friendable;

use BrianFaust\ServiceProvider\ServiceProvider;

class FriendableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishMigrations();
    }

    /**
     * Get the default package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return 'friendable';
    }
}
