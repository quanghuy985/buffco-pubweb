# This project is not under development anymore. Check spescina/imgproxy instead
I think that this feature has to be left outside the framework. I don't like that Laravel has to be booted upon each image request.



# Timthumb
An image proxy for Laravel

## Installation
To install __Timthumb__ as a Composer package to be used with Laravel 4, simply add this to your `composer.json`:
```javascript
"spescina/timthumb": "1.0.*"
```
and run composer update.

Once it's installed, you have to register the service provider. In `app/config/app.php` add the following line of code to the `providers` array:
```php
'Spescina\Timthumb\TimthumbServiceProvider'
```
If you want in `app/config/app.php` add the following line of code to the `alias` array
```php
'Timthumb' => 'Spescina\Timthumb\Facades\Timthumb'
```
Then, publish the config files with `php artisan config:publish spescina/timthumb`.

Then, publish the asset files with `php artisan asset:publish spescina/timthumb`.

## Usage
Generate the image link with the following line of code
```php
$url = Timthumb::link('path/to/image.jpg',width,height)
```
Set 0 width or 0 height to let Timthumb mantain the original image ratio
