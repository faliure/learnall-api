<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:api')]
class ApiMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {--f|force} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new model, migration, seeder, factory, policy, resource, CRUD controller, and requests.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('make:model', [
            '--all'   => true, // Migration, Seeder, Factory, Policy, Controller, FormRequests
            '--api'   => true, // The Controller should be an API Resource Controller
            '--force' => $this->option('force'),
            'name'    => $this->argument('name'),
        ]);

        $this->call('make:resource', [
            '--force' => $this->option('force'),
            'name' => "{$this->argument('name')}Resource",
        ]);

        return Command::SUCCESS;
    }
}
