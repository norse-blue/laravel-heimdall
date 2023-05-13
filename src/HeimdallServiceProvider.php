<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use ArgumentCountError;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use NorseBlue\Heimdall\Console\InstallCommand;
use NorseBlue\Heimdall\Enums\EntityType;
use NorseBlue\Heimdall\Facades\Registrar as RegistrarFacade;
use NorseBlue\Heimdall\Registrar\PermissionRegistrar;
use NorseBlue\Heimdall\Registrar\RoleRegistrar;

class HeimdallServiceProvider extends ServiceProvider
{
    public const REGISTRAR_ALIAS = 'heimdall-registrar';

    public function boot(): void
    {
        $this->configurePublishing();
        $this->configureCommands();
        $this->loadConfigEntities('heimdall.permissions', EntityType::Permission);
        $this->loadConfigEntities('heimdall.roles', EntityType::Role);
        $this->registerPermissionsGate();
    }

    /**
     * @return array<string>
     */
    public function provides(): array
    {
        return [
            Registrar::class,
            self::REGISTRAR_ALIAS,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/heimdall.php', 'heimdall');
        $this->app->singleton(Registrar::class, fn ($app) => new Registrar(
            $app->make(PermissionRegistrar::class),
            $app->make(RoleRegistrar::class),
        ));
        $this->app->alias(Registrar::class, self::REGISTRAR_ALIAS);
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

    protected function configurePublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/heimdall.php' => config_path('heimdall.php'),
        ], 'heimdall-config');
    }

    /**
     * @param  string  $key The config key that holds the entities.
     * @param  EntityType  $type The type of entity we want to load from config.
     */
    protected function loadConfigEntities(string $key, EntityType $type): void
    {
        /** @var array<string> $entities */
        $entities = config($key);

        collect($entities)
            ->each(function ($params) use ($key, $type): void {
                if (is_string($params)) {
                    if (! class_exists($params) || ! is_subclass_of($params, $type->definitionType())) {
                        Log::warning("Invalid entry found for $key config value.", [
                            'config-class' => $params,
                            'class-exists' => class_exists($params),
                            'expected-type' => $type->definitionType(),
                            'is-type' => false,
                        ]);

                        return;
                    }

                    $params = $params::definition();
                }

                try {
                    $this->registerEntity($type, $params);
                } catch (ArgumentCountError $exception) {
                    Log::warning(
                        "Invalid entry found in $key config.",
                        ['invalid-entry' => $params, 'exception' => $exception]
                    );
                }
            });
    }

    /**
     * @param array{
     *   key: string,
     *   name: string,
     *   description: string,
     *   permissions?: array<string>,
     * } $params
     */
    protected function registerEntity(EntityType $type, array $params): void
    {
        RegistrarFacade::create($type, $params);
    }

    protected function registerPermissionsGate(): void
    {
        /** @var Gate $gate */
        $gate = app(Gate::class);

        $gate->before(function (Authorizable $user, string $permission) {
            if (method_exists($user, 'hasPermission')) {
                return $user->hasPermission($permission) ?: null;
            }

            return null;
        });
    }
}
