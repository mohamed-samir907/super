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
        name: $name = $this->ask('Controller name');
        if (empty($name)) {
            $this->error('Controller name is required');
            goto name;
        }

        $this->controller($name);

        $this->info("Samirz Controller Cerated Successfully!\n");
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
}
