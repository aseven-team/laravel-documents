<?php

namespace AsevenTeam\Documents;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\Drivers\BrowsershotDriver;
use AsevenTeam\Documents\Drivers\DriverDecorator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DocumentManager
{
    /** @var DriverDecorator[] */
    protected array $drivers = [];

    public function driver(string $driver = null): DriverDecorator
    {
        $driver ??= $this->getDefaultDriver();

        $config = $this->getDriverConfig($driver);

        if (is_null($config)) {
            throw new InvalidArgumentException("Driver [{$driver}] is not defined.");
        }

        if (! isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($config);
        }

        return $this->drivers[$driver];
    }

    protected function createDriver(array $config): DriverDecorator
    {
        $method = 'create'.Str::studly($config['driver']).'Driver';

        if (! method_exists($this, $method)) {
            throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
        }

        /** @var Driver $driver */
        $driver = $this->$method();

        return new DriverDecorator($driver, $config['disk']);
    }

    protected function createBrowsershotDriver(): Driver
    {
        return new BrowsershotDriver();
    }

    protected function getDriverConfig(string $driver): ?array
    {
        return config("documents.drivers.{$driver}");
    }

    protected function getDefaultDriver(): string
    {
        return config('documents.default');
    }

    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
