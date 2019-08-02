<?php

namespace Samirz\Super\Console\Commands;

use File;
use Illuminate\Console\Command;

class SuperCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samirz:super-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super CRUD with service repository pattern';

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

        if (! $this->check_exist(app_path("/Models/{$name}.php"), 'Model')) {
            $this->model($name, $fillable);
            $this->info("Model Created Successfully!");
        } else
            $this->error('Model is already exists');

        if(! $this->check_exist(app_path("/Repositories/{$name}Repository.php"), 'Repository')) {
            $this->repository($name);
            $this->info("Repository Created Successfully!");
        } else
            $this->error('Repository is already exists');

        if(! $this->check_exist(app_path("/Services/{$name}Service.php"), 'Service')) {
            $this->service($name);
            $this->info("Service Created Successfully!");
        } else
            $this->error('Service is already exists');

        if (! $this->check_exist(app_path("/Http/Requests/{$name}Request.php"), 'Request')) {
            $this->request($name, $fillable);
            $this->info("Request Created Successfully!");
        } else
        $this->error('Request is already exists');

        if (! $this->check_exist(app_path("/Http/Controllers/{$name}Controller.php"), 'Controller')) {
            $this->controller($name);
            $this->info("Controller Created Successfully!");
        } else
            $this->error('Controller is already exists');

        if (! $this->check_exist(app_path("/Models/{$name}.php"), 'Model')) {
            File::append(
                base_path('routes/web.php'),
                'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');\n"
            );
            $this->info("Route resource Created Successfully!\n");

            $this->info("Super CRUD Created Successfully!\n");
        }
    }

    /**
     * Get the stub file
     *
     * @param  string $type
     * @return mixed
     */
    protected function getStub($type)
    {
        $stub = __DIR__ . '/../Stubs/'.$type.'.stub';

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

    /**
     * Make the controller class
     *
     * @param  string $name
     * @return void
     */
    protected function controller($name)
    {
        $space          = explode('/', $name);
        $className      = last($space);
        $namespace      = 'App\Http\Controllers';
        $modelPath      = str_replace('/', '\\', $name);
        $requestPath    = $modelPath . 'Request';

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $controllerTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{modelPath}}',
                '{{requestPath}}',
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $namespace,
                $modelPath,
                $requestPath,
                $className,
                strtolower(str_plural($className)),
                strtolower($className)
            ],
            $this->getStub('Controller')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    /**
     * Make the request class
     *
     * @param  string $name
     * @return void
     */
    protected function request($name, $fillable)
    {
        $space          = explode('/', $name);
        $className      = last($space);
        $namespace      = 'App\Http\Requests';
        $rules          = '';

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        if (!empty($fillable)) {
            $fields = explode(',', $fillable);

            foreach($fields as $field)
                $rules .= $field . " => 'required',\n";
        }

        $requestTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{modelName}}',
                '{{rules}}'
            ],
            [
                $namespace,
                $className,
                $rules
            ],
            $this->getStub('Request')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
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
            $this->getStub('Service')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Services/{$name}Service.php"), $serviceTemplate);
    }

    /**
     * Make the repository class
     *
     * @param  string $name
     * @return void
     */
    protected function repository($name)
    {
        $space          = explode('/', $name);
        $className      = last($space);
        $namespace      = 'App\Repositories';
        $modelPath      = str_replace('/', '\\', $name);

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $repositoryTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{modelPath}}',
                '{{modelName}}'
            ],
            [
                $namespace,
                $modelPath,
                $className
            ],
            $this->getStub('Repository')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Repositories/{$name}Repository.php"), $repositoryTemplate);
    }

    /**
     * Check if the file exists or not
     *
     * @param  string $path
     * @param  string $type
     * @return void
     */
    private function check_exist($path, $type)
    {
        if(!file_exists($path))
            return false;

        return true;
    }
}
