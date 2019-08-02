<?php

namespace Modules\Empresas\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Empresas\Events\Handlers\RegisterEmpresasSidebar;

class EmpresasServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterEmpresasSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('empresas', array_dot(trans('empresas::empresas')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('empresas', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Empresas\Repositories\EmpresaRepository',
            function () {
                $repository = new \Modules\Empresas\Repositories\Eloquent\EloquentEmpresaRepository(new \Modules\Empresas\Entities\Empresa());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Empresas\Repositories\Cache\CacheEmpresaDecorator($repository);
            }
        );
// add bindings

    }
}
