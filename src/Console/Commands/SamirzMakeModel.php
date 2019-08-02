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

        $fillable = $this->ask('fillable', '');

        $this->model($name, $fillable);

        $this->info("Samirz Model Cerated Successfully!");
    }

    /**
     * Get the stub file
     *
     * @return mixed
     */
    protected function getStub()
    {
        $stub = __DIR__ . '/../Stubs/Controller.stub';

        return file_get_contents($stub);
    }

    /**
     * Make the model class
     *
     * @param  string $name
     * @return void
     */
    protected function model($name, $fillable)
    {
        $space = explode('/', $name);
        $className = last($space);
        $namespace = 'App\Models';

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $modelTemplate = str_replace(
            [
                '{{fillable}}',
                '{{modelName}}',
                '{{DummyNamespace}}'
            ],
            [
                $fillable,
                $className,
                $namespace
            ],
            $this->getStub('Model')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }
}
