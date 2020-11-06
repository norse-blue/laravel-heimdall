<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use ArgumentCountError;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use NorseBlue\Heimdall\Console\InstallCommand;
use NorseBlue\Heimdall\Contracts\DefinesEntity;
use NorseBlue\Heimdall\Contracts\DefinesPermission;
use NorseBlue\Heimdall\Contracts\DefinesRole;
use NorseBlue\Heimdall\Exceptions\InvalidEntityContractException;

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
        $this->loadConfigEntities('heimdall.permissions', DefinesPermission::class);
        $this->loadConfigEntities('heimdall.roles', DefinesRole::class);
        $this->registerPermissionsGate();
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

    /**
     * @param string $key The config key that holds the entities.
     * @param string $contract The full qualified contract that must implement the entity.
     */
    protected function loadConfigEntities(string $key, string $contract): void
    {
        $base_contract = DefinesEntity::class;
        if (! is_subclass_of($contract, $base_contract)) {
            throw new InvalidEntityContractException("The contract ${contract} is not of type ${base_contract}.");
        }

        collect(config($key))
            ->each(static function ($item) use ($key, $contract): void {
                if (is_string($item)) {
                    if (! class_exists($item) || ! is_subclass_of($item, $contract)) {
                        Log::warning("Invalid entry found in ${key} config value.", ['invalid-entry' => $item]);

                        return;
                    }
                    $item = $item::definition();
                }

                try {
                    if (array_key_exists('permissions', $item)) {
                        AppRoles::create(...array_values($item));
                    } else {
                        AppPermissions::create(...array_values($item));
                    }
                } catch (ArgumentCountError $exception) {
                    Log::warning("Invalid entry found in ${key} config.", ['invalid-entry' => $item, 'exception' => $exception]);
                }
            });
    }

    protected function registerPermissionsGate(): void
    {
        app(Gate::class)->before(function (Authorizable $user, string $permission) {
            if (method_exists($user, 'hasPermission')) {
                return $user->hasPermission($permission) ?: null;
            }
        });
    }
}
