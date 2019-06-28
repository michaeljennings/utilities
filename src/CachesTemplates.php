<?php

namespace MichaelJennings\Utilities;

use Michaeljennings\Broker\Contracts\Cacheable;
use MichaelJennings\Utilities\Exceptions\NonCacheableEntityException;

trait CachesTemplates
{
    /**
     * Refine a single item using the supplied callback.
     *
     * @param mixed $raw
     * @return mixed
     * @throws \Exception
     */
    public function refineItem($raw)
    {
        if (! $raw instanceof Cacheable) {
            return parent::refineItem($raw);
        }

        $refined = broker()->remember($raw, 'refinery.template', function() use ($raw) {
            return $this->setTemplate($raw);
        });

        if ( ! empty($this->attachments)) {
            $refined = $this->merge($refined, $this->includeAttachments($raw));
        }

        return $refined;
    }
}
