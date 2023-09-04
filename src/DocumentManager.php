<?php

namespace AsevenTeam\Documents;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\Drivers\BrowsershotDriver;
use AsevenTeam\Documents\Drivers\DriverDecorator;
use AsevenTeam\Documents\Drivers\SnappyDriver;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DocumentManager
{
    /** @var DriverDecorator[] */
    protected array $drivers = [];

    public function driver(string $driver = null): DriverDecorator
    {
        $driver ??= $this->getDefaultDriver();

        if (! isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    protected function createDriver(string $driver): DriverDecorator
    {
        $method = 'create'.Str::studly($driver).'Driver';

        if (! method_exists($this, $method)) {
            throw new InvalidArgumentException("Driver [$driver] is not supported.");
        }

        /** @var Driver $driver */
        $driver = $this->$method();

        return new DriverDecorator($driver);
    }

    protected function createBrowsershotDriver(): Driver
    {
        return new BrowsershotDriver();
    }

    protected function createSnappyDriver(): Driver
    {
        return new SnappyDriver();
    }

    protected function getDefaultDriver(): string
    {
        return config('documents.default_driver');
    }

    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
