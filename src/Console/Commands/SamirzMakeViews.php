<?php

namespace Samirz\Super\Console\Commands;

use Illuminate\Console\Command;

class SamirzMakeViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samirz:make-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a views with samirz';

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

        $this->views($name);
        $this->info("Views Created Successfully!");

        $this->info("Samirz Views Cerated Successfully!\n");
    }

    /**
     * Get the stub file
     *
     * @return mixed
     */
    protected function getStub($name)
    {
        $stub = __DIR__ . '/../Stubs/views/'.$name.'.stub';

        return file_get_contents($stub);
    }

    /**
     * Create the views blade
     *
     * @param  string $name
     * @param  bool $ajax
     * @return void
     */
    protected function views($name, $ajax = true)
    {
        $views = [
            'index.blade',
            'script/index.blade',
            'script/trash.blade'
        ];

        foreach($views as $view) {
            $this->makeView($name, $view);
        }
    }

    /**
     * Make the view file
     *
     * @param  string $name
     * @param  string $view
     * @return void
     */
    protected function makeView($name, $view)
    {
        $space      = explode('/', $name);
        $className  = array_pop($space);
        $namespace  = strtolower(implode('/', $space). '/' . str_plural($className));

        $direcotory = resource_path('views/' . str_replace('\\', '/', $namespace));

        if (strpos($view, 'script/') === 0) {
            // $view = str_replace('script/', '', $view);
            $direcotory .= '/script';
        }

        $stub = $this->getStub($view);

        $viewTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $className,
                str_plural($className),
                strtolower(str_plural($className)),
                strtolower($className)
            ],
            $stub
        );

        if(!file_exists($direcotory))
            mkdir($direcotory, 0777, true);

        file_put_contents(str_replace('/script', '', $direcotory) . '/' .$view . ".php", $viewTemplate);
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
