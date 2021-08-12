<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * @codeCoverageIgnore
 */
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heimdall:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Heimdall components and resources';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'heimdall-config', '--force' => true]);

        // Heimdall Provider...
        $this->installHeimdallServiceProvider();

        $this->info('Heimdall installed.');
    }

    /**
     * Install the Heimdall service providers in the application configuration file.
     */
    protected function installHeimdallServiceProvider(): void
    {
        // Service Providers...
        copy(
            __DIR__ . '/../../stubs/app/Providers/HeimdallServiceProvider.php.stub',
            app_path('Providers/HeimdallServiceProvider.php')
        );

        $contents = file_get_contents(config_path('app.php'));
        if ($contents !== false && ! Str::contains($contents, 'App\\Providers\\HeimdallServiceProvider::class')) {
            $this->replaceInFile(
                "\n    ],\n\n    /*\n    |--------------------------------------------------------------------------\n    | Class Aliases",
                "        App\Providers\HeimdallServiceProvider::class," . PHP_EOL . "\n    ],\n\n    /*\n    |--------------------------------------------------------------------------\n    | Class Aliases",
                config_path('app.php')
            );
        }
    }

    /**
     * Replace a given string within a given file.
     */
    protected function replaceInFile(string $search, string $replace, string $path): void
    {
        $contents = file_get_contents($path);

        if ($contents !== false) {
            file_put_contents($path, str_replace($search, $replace, $contents));
        }
    }
}
