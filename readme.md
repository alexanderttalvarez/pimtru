# Tutorial

Welcome. This is based on [JuanD MeGon course](https://www.udemy.com/api-restful-con-laravel-php-homestead-passport/) about building an API RESTful with Laravel.

## How to get responses in other language
When sending a request, add the header X-localization with the language code `es,en`. If none is added, it will get english by default.

## How to generate API documentation
This API is using the [Laravel-apidoc-generator](https://github.com/mpociot/laravel-apidoc-generator) by Mpociot to generate automatically the documentation for the methods you can use.

Be good and follow its instructions if you are editing the code.

Just run the following instruction to get your documentation updated.
```console
php artisan api:generate --routePrefix="*"
```