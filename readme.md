# Tutorial

This is an API RESTful which purpose is to feed different Product Inventory Managers in different devices.

## Inspiration
This software gets some inspiration from [JuanD MeGon course](https://www.udemy.com/api-restful-con-laravel-php-homestead-passport/) about building an API RESTful with the PHP Framework Laravel.

## How to get responses in other language
When sending a request, add the header X-localization with the language code `es,en`. If none is added, it will get english by default.

## How to generate API documentation
This API is using the [Laravel-apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator) by Mpociot to generate automatically the documentation for the methods you can use.

Be good and follow its instructions if you are editing the code.

Just run the following instruction to get your documentation updated.
```console
php artisan api:generate --routePrefix="*"
```