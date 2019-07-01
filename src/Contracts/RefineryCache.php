<?php

namespace MichaelJennings\Utilities\Contracts;

interface RefineryCache
{
    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param mixed    $raw
     * @param string   $refineryKey
     * @param callable $callback
     * @return mixed
     */
    public function remember($raw, string $refineryKey, callable $callback);
}
