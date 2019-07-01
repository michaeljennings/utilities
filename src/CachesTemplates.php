<?php

namespace MichaelJennings\Utilities;

use MichaelJennings\Utilities\Contracts\RefineryCache;

trait CachesTemplates
{
    /**
     * The refinery cache implementation.
     *
     * @var RefineryCache
     */
    protected $cache;

    /**
     * Refine a single item uing the supplied callback.
     *
     * @param mixed $raw
     * @return mixed
     * @throws \Exception
     */
    public function refineItem($raw)
    {
        if (! $this->cache) {
            $this->cache = app(RefineryCache::class);
        }

        $refined = $this->cache->remember($raw, $this->refineryKey(), function() use ($raw) {
            return $this->setTemplate($raw);
        });

        if ( ! empty($this->attachments)) {
            $refined = $this->merge($refined, $this->includeAttachments($raw));
        }

        return $refined;
    }

    /**
     * Generate a key for the refinery.
     *
     * @return string
     */
    protected function refineryKey(): string
    {
        return 'refinery.template.' . get_class($this);
    }
}
