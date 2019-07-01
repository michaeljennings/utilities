<?php

namespace MichaelJennings\Utilities;

use MichaelJennings\Utilities\Contracts\RefineryCache;

trait CachesTemplates
{
    /**
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

        $refined = $this->cache->remember($raw, 'refinery.template.' . get_class($this), function() use ($raw) {
            return $this->setTemplate($raw);
        });

        if ( ! empty($this->attachments)) {
            $refined = $this->merge($refined, $this->includeAttachments($raw));
        }

        return $refined;
    }
}
