<?php

namespace MichaelJennings\Utilities\Tests;

use MichaelJennings\Utilities\DomainBuilder;

class DomainBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_a_domain()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->get('app');

        $this->assertEquals('http://app.testing.com', $url);
    }

    /**
     * @test
     */
    public function it_dynamically_builds_a_domain()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app();

        $this->assertEquals('http://app.testing.com', $url);
    }

    /**
     * @test
     */
    public function it_statically_builds_a_dynamic_app()
    {
        config()->set('utilities.domains', [
            'app' => 'http://app.testing.com',
        ]);

        $url = DomainBuilder::app();

        $this->assertEquals('http://app.testing.com', $url);
    }

    /**
     * @test
     */
    public function it_appends_the_parameter_to_the_domain()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app('testing/foo');

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_statically_appends_the_parameter_to_the_domain()
    {
        config()->set('utilities.domains', [
            'app' => 'http://app.testing.com',
        ]);

        $url = DomainBuilder::app('testing/foo');

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_appends_the_path_as_an_array()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app([
            'testing',
            'foo'
        ]);

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_statically_appends_to_the_path_with_an_array()
    {
        config()->set('utilities.domains', [
            'app' => 'http://app.testing.com',
        ]);

        $url = DomainBuilder::app([
            'testing',
            'foo'
        ]);

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_appends_the_path_as_an_additional_parameters()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app('testing', 'foo');

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_statically_appends_the_path_as_an_additional_parameters()
    {
        config()->set('utilities.domains', [
            'app' => 'http://app.testing.com',
        ]);

        $url = DomainBuilder::app('testing', 'foo');

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_appends_to_the_domain_and_strips_invalid_characters()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app(' /testing/foo ');

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_appends_an_array_to_the_domain_and_strips_invalid_characters()
    {
        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $url = $domainBuilder->app([' /testing ', ' foo/ ']);

        $this->assertEquals('http://app.testing.com/testing/foo', $url);
    }

    /**
     * @test
     */
    public function it_loads_the_domains_from_the_config_if_none_are_passed()
    {
        config()->set('utilities.domains.app', 'http://app.testing.com');

        $domainBuilder = new DomainBuilder();

        $url = $domainBuilder->app();

        $this->assertEquals('http://app.testing.com', $url);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_domain_is_not_set()
    {
        $this->expectException('\MichaelJennings\Utilities\Exceptions\DomainNotSetException');

        $domainBuilder = new DomainBuilder([
            'app' => 'http://app.testing.com',
        ]);

        $domainBuilder->api();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_no_domains_are_set()
    {
        $this->expectException('\MichaelJennings\Utilities\Exceptions\DomainNotSetException');

        $domainBuilder = new DomainBuilder();

        $domainBuilder->api();
    }
}
