<?php

namespace MichaelJennings\Utilities\Refinery;

use Exception;
use Michaeljennings\Broker\Contracts\Cacheable;
use MichaelJennings\Utilities\Contracts\RefineryCache;

class Cache implements RefineryCache
{
    /**
     * A map of items already retrieved from the cache.
     *
     * @var array
     */
    protected $refined = [];

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param mixed    $raw
     * @param string   $refineryKey
     * @param callable $callback
     * @return mixed
     */
    public function remember($raw, string $refineryKey, callable $callback)
    {
        try {
            $key = $this->makeKey($raw, $refineryKey);
        } catch (Exception $e) {
            return $callback();
        }

        if (! array_key_exists($key, $this->refined)) {
            $this->refined[$key] = $this->refine($raw, $refineryKey, $callback);
        }

        return $this->refined[$key];
    }

    /**
     * Refine the raw value against its template.
     *
     * @param mixed    $raw
     * @param string   $key
     * @param callable $callback
     * @return mixed
     */
    protected function refine($raw, string $key, callable $callback)
    {
        if (! $raw instanceof Cacheable) {
            return $callback();
        }

        return broker()->remember($raw, $key, $callback);
    }

    /**
     * Make the local key to store the refinery item against in memory.
     *
     * @param mixed  $raw
     * @param string $refineryKey
     * @return string
     */
    protected function makeKey($raw, string $refineryKey): string
    {
        if ($raw instanceof Cacheable) {
            return "$refineryKey.{$raw->getCacheKey()}.{$raw->getKey()}.";
        }

        return "$refineryKey." . json_encode($raw);
    }
}
