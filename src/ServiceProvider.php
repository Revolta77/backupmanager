<?php

namespace Revolta77\BackupManager;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Revolta77\BackupManager\Console\BackupCommand;
use Revolta77\BackupManager\Console\BackupListCommand;
use Revolta77\BackupManager\Console\BackupRestoreCommand;

class ServiceProvider extends BaseServiceProvider
{
	const PACKAGE = 'backupmanager';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

		$this->loadRoutesFrom(__DIR__.'/Http/routes.php');

        // views
        $this->loadViewsFrom(__DIR__ . '/Views', 'backupmanager', self::PACKAGE);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Config/config.php' => config_path('backupmanager.php'),
                __DIR__ . '/Migrations' => database_path('migrations'),
				__DIR__ . '/Views' => base_path('resources/views/vendor/' . self::PACKAGE)
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'BackupManager');

        $this->app->bind('command.backupmanager.create', BackupCommand::class);
        $this->commands('command.backupmanager.create');

        $this->app->bind('command.backupmanager.list', BackupListCommand::class);
        $this->commands('command.backupmanager.list');

        $this->app->bind('command.backupmanager.restore', BackupRestoreCommand::class);
        $this->commands('command.backupmanager.restore');

        $this->app->singleton('BackupManager', function () {
            return $this->app->make(BackupManager::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['BackupManager'];
    }
}
