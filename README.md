<<<<<<< HEAD
[![Build Status](https://travis-ci.org/laravel-flag-system}.png?branch=master)](https://travis-ci.org/ahmetcelikezer/laravel-flag-system)

# Laravel Flag System
=======
# Laravel Flag System - [ In Dev - Not Usable For Now]
[![Build Status](https://travis-ci.org/ahmetcelikezer/laravel-flag-system}.png?branch=master)](https://travis-ci.org/ahmetcelikezer/laravel-flag-system)
>>>>>>> 1369d57279e05712cd386af3132e968acaeeb51c

This package is in development stage, i will create manual right after my first release. The main idea is you can assign flags (flags are like hashtags) to any data in your any database table and you can manage, check these flags.

# Installation

Add laravel-flag-system to your composer.json using this command bellow:

```sh
$ composer require ahmetcelikezer/laravel-flag-system
```

Next if you are using Laravel 5.5 or newer version, Laravel Package Auto-Discovery will add this service provider automatically.

If you are using Laravel 5.4 or older version, you must add provider manually. Use the steps bellow:

 - Go to /config/app.php
 - Add ahmetcelikezer\laravelFlagSystem\FlagSystemServiceProvider::class, to 'providers' array
 
Right after, the package needs to create it's own migrations, so you must use Laravel's migrate command like bellow
```sh
$ php artisan migrate
```

