<?php



declare(strict_types=1);



namespace BrianFaust\Friendable;

use BrianFaust\ServiceProvider\AbstractServiceProvider;

class FriendableServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishMigrations();
    }

    /**
     * Get the default package name.
     *
     * @return string
     */
    public function getPackageName(): string
    {
        return 'friendable';
    }
}
