<?php

namespace MichaelJennings\Utilities\Contracts;

interface CachesTemplates
{
    /**
     * Get the key to cache the template against.
     *
     * @param mixed $item
     * @return mixed
     */
    public function cacheKey($item);
}
