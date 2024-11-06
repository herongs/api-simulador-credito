<?php

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateCrud extends Command
{
    protected $signature = 'create:crud {name}';
    protected $description = 'Create CRUD operations including Model, Repository, Service, Controller, DTO, Request, Resource, and Collection';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $this->createModel($name);
        $this->createRepositoryInterface($name);
        $this->createRepository($name);
        $this->createService($name);
        $this->createController($name);
        $this->createDto($name);

        $this->createRequest($name);
        $this->createResource($name);
        $this->createCollection($name);
        $this->updateAppServiceProvider($name);
        $this->info('CRUD operations created successfully!');
    }

    protected function createModel($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        $this->put("app/Models/{$name}.php", $modelTemplate);
    }

    protected function createRepositoryInterface($name)
    {
        $interfaceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('RepositoryInterface')
        );

        $this->put("app/Repositories/{$name}RepositoryInterface.php", $interfaceTemplate);
    }

    protected function createRepository($name)
    {
        $repositoryTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Repository')
        );

        $this->put("app/Repositories/{$name}Repository.php", $repositoryTemplate);
    }

    protected function createService($name)
    {
        $serviceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );

        $this->put("app/Services/{$name}Service.php", $serviceTemplate);
    }

    protected function createController($name)
    {
        $controllerTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Controller')
        );

        $this->put("app/Http/Controllers/{$name}Controller.php", $controllerTemplate);
    }

    protected function createDto($name)
    {
        $dtoTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Dto')
        );

        $this->put("app/DataTransferObjects/{$name}Dto.php", $dtoTemplate);
    }

    protected function createRequest($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        $this->put("app/Http/Requests/{$name}Request.php", $requestTemplate);
    }

    protected function createResource($name)
    {
        $resourceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Resource')
        );

        $this->put("app/Http/Resources/{$name}Resource.php", $resourceTemplate);
    }

    protected function createCollection($name)
    {
        $collectionTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Collection')
        );

        $this->put("app/Http/Resources/{$name}Collection.php", $collectionTemplate);
    }

    protected function updateAppServiceProvider($name)
    {
        $providerPath = app_path('Providers/AppServiceProvider.php');
        $content = $this->files->get($providerPath);

        // Add binding
        $binding = "        {$name}RepositoryInterface::class => {$name}Repository::class,";
        $content = preg_replace(
            '/(public \$bindings = \[)/',
            "$1\n$binding",
            $content
        );

        // Add use statement
        $useStatement = "use App\Repositories\\{$name}RepositoryInterface;\nuse App\Repositories\\{$name}Repository;";
        $content = preg_replace(
            '/(use Illuminate\\\Support\\\ServiceProvider;)/',
            "$1\n\n{$useStatement}",
            $content
        );

        $this->files->put($providerPath, $content);
    }

    protected function getStub($type)
    {
        return $this->files->get(storage_path("stubs/{$type}.stub"));
    }

    protected function put($path, $contents)
    {
        $this->files->put($path, $contents);
    }
}
