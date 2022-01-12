# Introduction

Bagisto Search-suggestion is a feature to make it faster to complete searches that you're beginning to type. Its make your website more attractive.

It packs in lots of demanding features that allows your business to scale in no time:

- product category will be visible on auto search suggestion
- product image will be visible on auto search suggestion result
- price of each product will be visible on search suggestion
- total searched term will be visible on search suggestion
- admin can disable visiblity of category/product/term from the auto search
- admin can set total number of categories/product visible on auto search suggestion

## Requirements:

- **Bagisto**: v1.3.0 or higher.

## Installation with composer:
- Run the following command
```
composer require bagisto/bagisto-search-suggestion
```

- Goto config/concord.php file and add following line under 'modules'
```php
\Webkul\suggestion\Providers\ModuleServiceProvider::class
```

- Run these commands below to complete the setup
```
composer dump-autoload
```

```
php artisan route:cache
php artisan config:cache
```

- Run Some npm commands in "suggestion" folder
```
npm install
npm run prod
```

```
php artisan vendor:publish --force
```
-> Press the number before "suggestionServiceProvider" class and then press enter to publish all assets and configurations.

## Installation without composer:

- Unzip the respective extension zip and then merge "suggestion" inside the webkul package.
- Goto config/app.php file and add following line under 'providers'

```
Webkul\suggestion\Providers\suggestionServiceProvider::class,
```

- Goto composer.json file and add following line under 'psr-4'

```
 "Webkul\\suggestion\\": "packages/Webkul/suggestion/src"
```

- Run these commands below to complete the setup

```
composer dump-autoload
```

```
php artisan config:cache
php artisan route:cache
```

- Run Some npm commands in "suggestion" folder
```
npm install
npm run prod
```

```
php artisan vendor:publish --force
```
-> Press the number before "Webkul\suggestion\Providers\suggestionServiceProvider" and then press enter to publish all assets and configurations.

> That's it.