<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use ArgumentCountError;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use NorseBlue\Heimdall\Console\InstallCommand;
use NorseBlue\Heimdall\Contracts\DefinesPermission;
use NorseBlue\Heimdall\Contracts\DefinesRole;

/**
 * @codeCoverageIgnore
 */
class HeimdallServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/heimdall.php', 'heimdall');
    }

    public function boot(): void
    {
        $this->configurePublishing();
        $this->configureCommands();
        $this->loadConfigPermissions();
        $this->loadConfigRoles();
    }

    protected function configurePublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/heimdall.php' => config_path('heimdall.php'),
        ], 'heimdall-config');
    }

    protected function configureCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    protected function loadConfigPermissions(): void
    {
        collect(config('heimdall.permissions'))
                ->each(function ($permission): void {
                    if (is_string($permission)) {
                        if (! class_exists($permission) || ! is_subclass_of($permission, DefinesPermission::class)) {
                            Log::warning('Invalid permission entry found in Heimdall config.', ['invalid-entry' => $permission]);

                            return;
                        }
                        $permission = $permission::definition();
                    }

                    try {
                        AppPermissions::create(...array_values($permission));
                    } catch (ArgumentCountError $exception) {
                        Log::warning('Invalid permission entry found in Heimdall config.', ['invalid-entry' => $permission, 'exception' => $exception]);
                    }
                });
    }

    protected function loadConfigRoles(): void
    {
        collect(config('heimdall.roles'))
            ->each(function ($role): void {
                if (is_string($role)) {
                    if (! class_exists($role) || ! is_subclass_of($role, DefinesRole::class)) {
                        Log::warning('Invalid role entry found in Heimdall config.', ['invalid-entry' => $role]);

                        return;
                    }
                    $role = $role::definition();
                }

                try {
                    AppRoles::create(...array_values($role));
                } catch (ArgumentCountError $exception) {
                    Log::warning('Invalid role entry found in Heimdall config.', ['invalid-entry' => $role, 'exception' => $exception]);
                }
            });
    }
}
