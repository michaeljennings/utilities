<?php

namespace MichaelJennings\Utilities\Tests;

use Illuminate\Support\Facades\Hash;
use MichaelJennings\Utilities\UtilityServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        Hash::setRounds(4);

        $this->migrate();
        $this->loadFactories();

        if (method_exists($this, 'loadFixtures')) {
            $this->loadFixtures();
        }
    }

    /**
     * Run the required migrations.
     */
    protected function migrate()
    {
        $this->artisan('migrate');
    }

    /**
     * Load the model factories.
     */
    protected function loadFactories()
    {
        //
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            UtilityServiceProvider::class,
        ];
    }
}
