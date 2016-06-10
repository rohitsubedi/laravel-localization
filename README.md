# Laravel localization

Very easy and light package for loclization. Routing based on available locales and easy to get rid of default language prefix from route

## Installation
### Composer
Add Laravel Localization to your composer.json file

    "rohit/laravel-localization": "^1.0"
Run `composer install` to get the latest version of package

Or you can directly run the `composer require` command

    composer require rohit/laravel-localization

### Configuration
After the package install is completed you need to configure `config/app.php` and add `Providers` and `Aliases`

```php
    'providers` => [
        .......
        .......
        Rohit\LaravelLocalization\LaravelLocalizationServiceProvider::class
    ]
```
```php
    'aliases' => [
        ......
        ......
        'Localization' => Rohit\LaravelLocalization\Facades\LaravelLocalization::class
    ]
```

### Vendor Publish
After the above steps, you need to publish vendor for this packge. It will create `laravel-localization.php` file under `config` folder. This folder contains the configuration for your locales.

    php artisan vendor:publish --provider="Rohit\LaravelLocalization\LaravelLocalizationServiceProvider"
    
The file `laravel-localization.php` will contain the following structure
```php
    return [
        // Add any language you want to support and comes as prefix in the url
        'all_locales' => [
            'en',
            'th'
        ],
        'default_locale' => 'th', // Default locale will not be shown in the url
    ];
```
Here you can add as many locales available in your project and set the `default_locale` to the value for which you want to exclude the prefix

__For Example:__

If your project has `en` and `th` as the available locales and if you set `th` as your default locale. Then the url will look like,

*For English:* `http://your_domain.com/en/your_page`

*For Thai* `http://your_domain.com/your_page`

It will skip default locale `th` from the url

### Middleware
After this, you need to update the `app\Http\Kernel.php` file and add the following line under `routeMiddleware`

```php
    protected $routeMiddleware = [
        ........
        ........
        'localization' => \Rohit\LaravelLocalization\Middleware\LanguageHandler::class,
    ]
```

### Routing
Finally you can manage all the routes with this configuration and middleware for smooth operation

Update `app\Http\routes.php` file and add all your routes under this group

```php
    Route::group([
        'prefix' => Localization::setLocale(),
        'middleware' => ['localization']
    ], function() {
        // All your routes here
    });
```
