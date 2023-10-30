Step 1: Install Laravel Passport (Secure Rest API)

composer require laravel/passport

Step 2: Migrate your Database

php artisan migrate

Step 3: Install Passport

php artisan passport:install

Integration of Swagger in Laravel Application

Step 1: Install Swagger open Api

composer require "darkaonline/l5-swagger"

Step 2: Publish Swagger’s configuration

php artisan vendor:publish --provider  "L5Swagger\L5SwaggerServiceProvider"

Step 3: Enable passport authentication

Enable passport authentication we need to uncomment Open API 3.0 support in security array of config/l5-swagger.php file

 'bearer' => [ // Unique name of security
                    'type' => 'apiKey', // Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'Enter token in format (Bearer <token>)',
                    'name' => 'Authorization', // The name of the header or query parameter to be used.
                    'in' => 'header', // The location of the API key. Valid values are "query" or "header".
                ],