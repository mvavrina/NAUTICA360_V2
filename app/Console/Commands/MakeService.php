<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vytvoří novou Service class';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . $name . '.php');

        if (File::exists($servicePath)) {
            $this->error("Třída $name již existuje.");
            return;
        }

        $stub = "<?php\n\nnamespace App\Services;\n\nclass $name\n{\n    // Vaše logika\n}";

        File::put($servicePath, $stub);
        $this->info("Service class $name byla úspěšně vytvořena.");
    }
}
