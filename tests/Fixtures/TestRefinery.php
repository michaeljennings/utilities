<?php

namespace MichaelJennings\Utilities\Tests\Fixtures;

use Michaeljennings\Refinery\Refinery;
use MichaelJennings\Utilities\CachesTemplates;

class TestRefinery extends Refinery
{
    use CachesTemplates;

    /**
     * Set the template the refinery will use for each item passed to it
     *
     * @param mixed $item
     * @return mixed
     */
    protected function setTemplate($item)
    {
        return [
            'id' => 1,
        ];
    }
}
