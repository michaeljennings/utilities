<?php

namespace MichaelJennings\Utilities;

use MichaelJennings\Utilities\Exceptions\DomainNotSetException;

/**
 * This class allows you to build URLs to multiple domains while
 * keeping using the same API throughout your application.
 *
 * @package MichaelJennings\Utilities
 */
class DomainBuilder
{
    /**
     * All of the configured domains.
     *
     * @var array
     */
    protected $domains;

    public function __construct(array $domains = null)
    {
        if (! $domains) {
            $domains = config('utilities.domains');
        }

        $this->domains = $domains;
    }

    /**
     * Check that the domain is set in the config and then attempt to build
     * the url.
     *
     * @param string            $key
     * @param string|array|null $path
     * @return string
     * @throws DomainNotSetException
     */
    public function get(string $key, $path = null): string
    {
        if (! $this->domains || ! array_key_exists($key, $this->domains)) {
            throw new DomainNotSetException("No domain has been set with the name '$key', add it to the utilities config.");
        }

        return $this->build($this->domains[$key], $path);
    }

    /**
     * Build a url with the provided name.
     *
     * @param string            $domain
     * @param string|array|null $paths
     * @return string
     */
    protected function build(string $domain, $paths = null): string
    {
        if (! $paths) {
            return $this->clean($domain);
        }

        if (! is_array($paths)) {
            $paths = [$paths];
        }

        array_unshift($paths, $this->clean($domain));

        $paths = array_map(function ($path) {
            return $this->clean($path);
        }, $paths);

        return implode('/', $paths);
    }

    /**
     * Clean erroneous characters from the beginning and end of the
     * string.
     *
     * @param string $string
     * @return string
     */
    protected function clean(string $string): string
    {
        return trim($string, " \t\n\r\0\x0B/");
    }

    /**
     * Attempt to build the correct domain by the method name.
     *
     * @param string $method
     * @param array  $arguments
     * @return null|string
     * @throws DomainNotSetException
     */
    public function __call($method, array $arguments): ?string
    {
        return $this->get($method, ...$arguments);
    }

    /**
     * Attempt to statically build the correct domain by the method name.
     *
     * @param string $method
     * @param array  $arguments
     * @return mixed
     */
    public static function __callStatic($method, array $arguments)
    {
        $builder = new static(config('utilities.domains'));

        return $builder->get($method, ...$arguments);
    }
}
