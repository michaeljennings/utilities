<?php

namespace MichaelJennings\Utilities\Tests\Fixtures;

use Michaeljennings\Broker\Contracts\Cacheable;

class CacheableItem implements Cacheable
{
    /**
     * Get the key to cache the attributes against.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return 'item';
    }

    /**
     * Get the unique key for the cacheable item.
     *
     * @return int|string
     */
    public function getKey()
    {
        return 1;
    }
}
