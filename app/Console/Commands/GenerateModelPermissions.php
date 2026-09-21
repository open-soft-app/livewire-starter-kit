<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class GenerateModelPermissions extends Command
{
    /**
     * Il nome e la firma del comando console.
     * Aggiungendo l'asterisco (models*) indichiamo che accetta un array di parametri.
     *
     * @var string
     */
    protected $signature = 'permission:generate {models* : La lista dei modelli per cui generare i permessi separati da spazio (es. Incidents Users Posts)}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Genera i permessi CRUD (create, read, update, delete) per una lista di modelli usando Spatie';

    /**
     * Esegui il comando console.
     *
     * @return int
     */
    public function handle()
    {
        // Recupera l'array di modelli passati in console
        $models = $this->argument('models');

        // Definisci le azioni CRUD
        $actions = ['create', 'read', 'update', 'delete'];

        // Cicla su ogni modello fornito
        foreach ($models as $modelName) {
            // Converte in minuscolo (es. "Incidents" diventa "incidents")
            $prefix = Str::lower($modelName);

            $this->info("⚙️ Generazione dei permessi per: {$modelName}...");

            foreach ($actions as $action) {
                $permissionName = "{$prefix}-{$action}";

                // firstOrCreate verifica se esiste già
                $permission = Permission::firstOrCreate([
                    'name'       => $permissionName,
                    'guard_name' => 'web',
                ]);

                if ($permission->wasRecentlyCreated) {
                    $this->line("   ✅ Creato: {$permissionName}");
                } else {
                    $this->line("   ⚠️ Già esistente: {$permissionName}");
                }
            }

            $this->newLine(); // Spazio tra un modello e l'altro nell'output
        }

        $this->info('🎉 Generazione completata con successo per tutti i modelli!');

        return Command::SUCCESS;
    }
}
