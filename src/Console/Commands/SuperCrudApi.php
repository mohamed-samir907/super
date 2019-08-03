<?php

namespace Samirz\Super\Console\Commands;

use File;
use Illuminate\Console\Command;

class SuperCrudApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samirz:super-crud-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super CRUD API with service repository pattern';

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

        if (! $this->check_exist(app_path("/Models/{$name}.php"))) {
            $this->model($name, $fillable);
            $this->info("Model Created Successfully!");
        } else
            $this->error('Model is already exists');

        if(! $this->check_exist(app_path("/Repositories/{$name}Repository.php"))) {
            $this->repository($name);
            $this->info("Repository Created Successfully!");
        } else
            $this->error('Repository is already exists');

        if(! $this->check_exist(app_path("/Services/{$name}Service.php"))) {
            $this->service($name);
            $this->info("Service Created Successfully!");
        } else
            $this->error('Service is already exists');

        if (! $this->check_exist(app_path("/Http/Requests/{$name}Request.php"))) {
            $this->request($name, $fillable);
            $this->info("Request Created Successfully!");
        } else
        $this->error('Request is already exists');

        if (! $this->check_exist(app_path("/Http/Resources/{$name}Resource.php"))) {
            $this->resource($name);
            $this->info("Resource Created Successfully!");
        } else
        $this->error('Resource is already exists');

        if (! $this->check_exist(app_path("/Http/Controllers/{$name}Controller.php"))) {
            $this->controller($name);
            $this->info("Controller Created Successfully!");
        } else
            $this->error('Controller is already exists');

        if ($this->check_exist(app_path("/Models/{$name}.php"))) {

            $this->route($name);
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
     * Append the resource route to the route file
     *
     * @param  string $name
     * @return mixed
     */
    protected function route($name)
    {
        $space      = explode('/', $name);
        $className  = array_pop($space);

        $pluralLowerCase = str_plural(strtolower($className));
        $lowerCase = strtolower($className);

        $name = str_replace('/', '\\', $name);

        File::append(
            base_path('routes/api.php'),
"
Route::get('" . $pluralLowerCase . "/trash', '{$name}Controller@trash')->name('" . $pluralLowerCase . ".trash');
Route::post('" . $pluralLowerCase . "/restore/{" . $lowerCase . "}', '{$name}Controller@restore')->name('" . $pluralLowerCase . ".restore');
Route::post('" . $pluralLowerCase . "/force/{" . $lowerCase . "}', '{$name}Controller@force')->name('" . $pluralLowerCase . ".force');
Route::apiResource('" . $pluralLowerCase . "', '{$name}Controller');\n"
        );
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
        $servicePath    = $modelPath . 'Service';
        $resourcePath   = $modelPath . 'Resource';

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $controllerTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{requestPath}}',
                '{{servicePath}}',
                '{{resourcePath}}',
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $namespace,
                $requestPath,
                $servicePath,
                $resourcePath,
                $className,
                strtolower(str_plural($className)),
                strtolower($className)
            ],
            $this->getStub('ControllerApi')
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
     * Make the resource class
     *
     * @param  string $name
     * @return void
     */
    protected function resource($name)
    {
        $space          = explode('/', $name);
        $className      = last($space);
        $namespace      = 'App\Http\Resources';

        if (count($space) > 1) {
            $namespace .= "\\" . str_replace('/', '\\', str_replace("/". $className, '', $name));
        }

        $direcotory = app_path(str_replace('App/', '', str_replace('\\', '/', $namespace)));

        $resourceTemplate = str_replace(
            [
                '{{DummyNamespace}}',
                '{{modelName}}'
            ],
            [
                $namespace,
                $className
            ],
            $this->getStub('Resource')
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(app_path("/Http/Resources/{$name}Resource.php"), $resourceTemplate);
    }

    /**
     * Check if the file exists or not
     *
     * @param  string $path
     * @param  string $type
     * @return void
     */
    private function check_exist($path)
    {
        if(!file_exists($path))
            return false;

        return true;
    }
}
