<?php
namespace Gumphp\Helper;

use Carbon\Carbon;
use Hyperf\Context\ApplicationContext;
use Hyperf\Filesystem\FilesystemFactory;
use Hyperf\Logger\LoggerFactory;
use Psr\SimpleCache\CacheInterface;

/**
 * @return \Psr\Container\ContainerInterface
 */
function app()
{
    return ApplicationContext::getContainer();
}

/**
 * @param $group
 * @param $name
 * @return \Psr\Log\LoggerInterface
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function logger($group = 'default', $name = 'app')
{
    return app()->get(LoggerFactory::class)->get($name, $group);
}

/**
 * @return mixed|CacheInterface
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function cache()
{
    return app()->get(CacheInterface::class);
}

/**
 * @param $name
 * @return \League\Flysystem\Filesystem
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function filesystem($name = 'local')
{
    return ApplicationContext::getContainer()->get(FilesystemFactory::class)->get($name);
}

/**
 * @param $condition
 * @param $exception
 * @param ...$parameters
 * @return mixed
 */
function throw_if($condition, $exception = 'RuntimeException', ...$parameters)
{
    if ($condition) {
        if (is_string($exception) && class_exists($exception)) {
            $exception = new $exception(...$parameters);
        }

        throw is_string($exception) ? new \RuntimeException($exception) : $exception;
    }

    return $condition;
}

if (! function_exists('now')) {
    /**
     * @return Carbon
     */
    function now()
    {
        return Carbon::now();
    }
}

/**
 * @param string $environment
 * @return bool
 */
function environment(string $environment)
{
    return \Hyperf\Support\env('APP_ENV') === $environment;
}