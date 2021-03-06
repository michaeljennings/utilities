<?php

namespace MichaelJennings\Utilities\Tests;

use Michaeljennings\Broker\BrokerServiceProvider;
use MichaelJennings\Utilities\Exceptions\NonCacheableEntityException;
use MichaelJennings\Utilities\Tests\Fixtures\CacheableItem;
use MichaelJennings\Utilities\Tests\Fixtures\TestRefinery;

class CachesTemplateTest extends TestCase
{
    public function loadFixtures()
    {
        $this->refinery = new TestRefinery();
    }

    /**
     * @test
     */
    public function it_caches_the_refined_template()
    {
        $refined = $this->refinery->refine(new CacheableItem());

        $cached = app('cache.store')->tags(['item', 'item.1'])->get('refinery.template.' . TestRefinery::class);

        $this->assertEquals($refined, $cached);
    }

    /**
     * @test
     */
    public function it_does_not_cache_if_the_raw_item_is_not_cacheable()
    {
        $this->refinery->refine([
            'id' => 1
        ]);

        $cached = app('cache.store')->tags(['item', 'item.1'])->get('refinery.template');

        $this->assertNull($cached);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        return array_merge(parent::getPackageProviders($app), [
            BrokerServiceProvider::class,
        ]);
    }
}
