<?php


namespace Dshorkin\ArrayableXml\Laravel;


use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Dshorkin\ArrayableXml\ArrayableXmlFactory;

class ArrayableXmlProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('arrayable-xml-factory', function (Container $container) {
            return $container->make(ArrayableXmlFactory::class);
        });
    }
}