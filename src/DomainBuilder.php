<?php

namespace MichaelJennings\Utilities;

use MichaelJennings\Utilities\Exceptions\DomainNotSetException;

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
        if ( ! $domains) {
            $domains = config('utilities.domains');
        }

        $this->domains = $domains;
    }

    /**
     * Build a url with the provided name.
     *
     * @param string      $domain
     * @param string|null $path
     * @return string
     */
    protected function build(string $domain, string $path = null): string
    {
        if ( ! $path) {
            return $this->clean($domain);
        }

        return $this->clean($domain, " \t\n\r\0\x0B/") . '/' . $this->clean($path);
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
        if ( ! array_key_exists($method, $this->domains)) {
            throw new DomainNotSetException("No domain has been set with the name '$method', add it to the utilities config.");
        }

        return $this->build($this->domains[$method], ...$arguments);
    }
}