# This is Laravel Server
All package for this server
## JWT token 
### Installation
Install via composer
Run the following command to pull in the latest version:
```bash
composer require tymon/jwt-auth
```
Add service provider ( Laravel 5.4 or below )
Add the service provider to the providers array in the config/app.php config file as follows:
```php
'providers' => [

    ...

    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
```
Publish the config
Run the following command to publish the package config file:
```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
You should now have a config/jwt.php file that allows you to configure the basics of this package.

Generate secret key
I have included a helper command to generate a key for you:
```bash
php artisan jwt:secret
```
This will update your .env file with something like JWT_SECRET=foobar

It is the key that will be used to sign your tokens. How that happens exactly will depend on the algorithm that you choose to use.

### Quick start
Update your User model
Firstly you need to implement the Tymon\JWTAuth\Contracts\JWTSubject contract on your User model, which requires that you implement the 2 methods getJWTIdentifier() and getJWTCustomClaims().

The example below should give you an idea of how this could look. Obviously you should make any changes, as necessary, to suit your own needs.
```php
<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
```
Configure Auth guard
Note: This will only work if you are using Laravel 5.2 and above.

Inside the config/auth.php file you will need to make a few changes to configure Laravel to use the jwt guard to power your application authentication.

Make the following changes to the file:
```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

...

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```
Here we are telling the api guard to use the jwt driver, and we are setting the api guard as the default.

We can now use Laravel's built in Auth system, with jwt-auth doing the work behind the scenes!

Add some basic authentication routes
First let's add some routes in routes/api.php as follows:
```php
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
```
Create the AuthController
Then create the AuthController, either manually or by running the artisan command:

php artisan make:controller AuthController
Then add the following:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
```
You should now be able to POST to the login endpoint (e.g. http://example.dev/auth/login) with some valid credentials and see a response like:
```json
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.TJVA95OrM7E2cBab30RMHrHDcEfxjoYZgeFONFh7HgQ",
    "token_type": "bearer",
    "expires_in": 3600
}
```
This token can then be used to make authenticated requests to your application.

Authenticated requests
There are a number of ways to send the token via http:

Authorization header
```json
Authorization: Bearer eyJhbGciOiJIUzI1NiI...
```
Query string parameter

http://example.dev/me?token=eyJhbGciOiJIUzI1NiI...

Post parameter

Cookies

Laravel route parameter

## Role and Permission
https://docs.spatie.be/laravel-permission/v3/introduction/
Consult the Prerequisites page for important considerations regarding your User models!

This package publishes a config/permission.php file. If you already have a file by that name, you must rename or remove it.

You can install the package via composer:
```bash
composer require spatie/laravel-permission
```
Optional: The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:
```php
'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
```
You should publish the migration and the config/permission.php config file with:
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
NOTE: If you are using UUIDs, see the Advanced section of the docs on UUID steps, before you continue. It explains some changes you may want to make to the migrations and config file before continuing. It also mentions important considerations after extending this package’s models for UUID capability.

Clear your config cache. This package requires access to the permission config. Generally it’s bad practice to do config-caching in a development environment. If you’ve been caching configurations locally, clear your config cache with either of these commands:
```bash
php artisan optimize:clear
# or
php artisan config:clear
```
Run the migrations: After the config and migration have been published and configured, you can create the tables for this package by running:
```bash
php artisan migrate
```
Add the necessary trait to your User model: Consult the Basic Usage section of the docs for how to get started using the features of this package.

Default config file contents
You can view the default config file contents at:

https://github.com/spatie/laravel-permission/blob/master/config/permission.php
