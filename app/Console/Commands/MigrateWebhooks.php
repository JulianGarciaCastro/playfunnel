<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateWebhooks extends Command
{
    protected $signature = 'webhooks:migrate {--force : Force the operation to run in production}';

    protected $description = 'Ejecuta solo las migraciones de la integracion de webhooks';

    protected $migrationPaths = [
        'database/migrations/2026_05_07_170000_create_webhook_integrations_table.php',
        'database/migrations/2026_05_07_170100_create_webhook_integration_projects_table.php',
        'database/migrations/2026_05_07_170200_create_webhook_deliveries_table.php',
    ];

    public function handle()
    {
        foreach ($this->migrationPaths as $path) {
            $this->info('Migrating: ' . $path);

            $exitCode = Artisan::call('migrate', [
                '--path' => $path,
                '--force' => (bool) $this->option('force'),
            ]);

            $output = trim(Artisan::output());
            if ($output !== '') {
                $this->line($output);
            }

            if ($exitCode !== 0) {
                $this->error('Error ejecutando la migracion: ' . $path);
                return $exitCode;
            }
        }

        $this->info('Migraciones de webhooks ejecutadas correctamente.');
        return 0;
    }
}
