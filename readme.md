# Utilities

This package contains a series of utility classes that I use frequently in projects, most of the utilities are built with laravel in mind.

### Installation

Install using `composer require michaeljennings/utilities`.

### Refinery Caching

Occasionally when using the [refinery](https://github.com/michaeljennings/refinery) package you may have templates that are quite intensive to run.

To fix this you can use the `CachesTemplates` trait.

Firstly, you need to install the [michaeljennings/broker](https://github.com/michaeljennings/broker) package.

Then on the class you want to refine implement the `Cacheable` interface. See the broker documentation for more information.

```php
// Item being refined
class ToRefine implements Michaeljennings\Broker\Contracts\Cacheable
{
    /**
     * Get the key to cache the attributes against.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return 'test';
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
```

Finally implement the `CachesTemplates` trait on your refinery.

```php
class Example extends Michaeljennings\Refinery\Refinery
{
    use CachesTemplates;
    
    public function setTemplate($item)
    {
        //
    }
}
```

### Domain Builder

Very frequently I build projects that use multiple subdomains. I also find I need to create links between subdomains quite frequently but I don't want to hard code the links.

This class allows you to create links between multiple domains, but use the same API throughout your application.

Firstly you need to define the domains in the `utilities.php` config file.

```php
'domains' => [
  'app' => 'http://app.example.com',
  'api' => 'http://api.example.com',
]
```

Then you can either hit the `get` method, or dynamically hit the key you have set.

```php
$url = $domainBuilder->get('app'); // http://app.example.com
$url = $domainBuilder->app(); // http://app.example.com
```

You can also pass anything you want to be appended to the url as an argument.

```php
$url = $domainBuilder->get('app', 'foo/bar'); // http://app.example.com/foo/bar
$url = $domainBuilder->app('foo/bar'); // http://app.example.com/foo/bar
```

I usually resolve class using laravel's IOC container, but if you want to new it up yourself you just need to pass the config to the constructor.

```php
$domainBuilder = new MichaelJennings\Utilities\DomainBuilder(config('utilities.domains'));
```
