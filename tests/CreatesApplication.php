<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->guardAgainstUsingWorkDatabaseForTests($app);

        return $app;
    }

    protected function guardAgainstUsingWorkDatabaseForTests($app): void
    {
        if (! $app->environment('testing')) {
            return;
        }

        $defaultConnection = (string) config('database.default');
        $connectionConfig = (array) config("database.connections.{$defaultConnection}", []);
        $databaseName = (string) ($connectionConfig['database'] ?? '');

        $isSqliteMemory = $defaultConnection === 'sqlite' && $databaseName === ':memory:';
        $isSqliteTestingFile = $defaultConnection === 'sqlite' && str_contains(strtolower($databaseName), 'testing');
        $isDedicatedTestingDatabase = (bool) preg_match('/(?:_test|testing)$/i', $databaseName);

        if ($isSqliteMemory || $isSqliteTestingFile || $isDedicatedTestingDatabase) {
            return;
        }

        throw new RuntimeException(
            sprintf(
                "Unsafe test database configuration detected (connection: %s, database: %s). Configure a dedicated testing DB before running tests.",
                $defaultConnection,
                $databaseName !== '' ? $databaseName : '(empty)'
            )
        );
    }
}
