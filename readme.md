# Utilities

This package contains a series of utility classes that I use frequently in projects, most of the utilities are built with laravel in mind.

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