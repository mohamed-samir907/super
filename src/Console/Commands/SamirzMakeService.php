<?php

namespace Samirz\Super\Console\Commands;

use Illuminate\Console\Command;

class SamirzMakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samirz:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a controller related to samirz super crud';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        name: $name = $this->ask('Model name');
        if (empty($name)) {
            $this->error('Model name is required');
            goto name;
        }

        $this->service($name);

        $this->info("Samirz Service Cerated Successfully!\n");
    }

    /**
     * Get the stub file
     *
     * @return mixed
     */
    protected function getStub()
    {
        $stub = __DIR__ . '/../Stubs/Service.stub';

        return file_get_contents($stub);
    }

    /**
     * Make the service class
     *
     * @param  string $name
     * @return void
     */
    protected function service($name)
    {
        $space          = explode('/', $name);
        $className      = last($space);
        $namespace      = 'App\Services';
        $modelPath      = str_replace('/', '\\', $name);

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $serviceTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $namespace,
                $className,
                strtolower($className)
            ],
            $this->getStub()
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Services/{$name}Service.php"), $serviceTemplate);
    }
}
