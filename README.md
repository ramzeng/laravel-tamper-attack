<h1 align="center"> laravel-tamper-attack </h1>

<p align="center"> laravel middleware to prevent tamper attacks..</p>


## Installing

```bash
$ composer require ramzeng/laravel-tamper-attack -vvv
```

## Usage

### Publish config

```bash
$ php artisan vendor:publish --provider="Ramzeng\LaravelTamperAttack\ServiceProvider"
```

### Add middleware

```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $middleware = [
        \Ramzeng\LaravelTamperAttack\Middlewares\TamperAttack::class,
    ];
    
    ...
    ...
}
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/ramzeng/laravel-tamper-attack/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/ramzeng/laravel-tamper-attack/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT