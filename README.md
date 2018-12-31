# Laravel Flag System - Development Test
[![CircleCI](https://circleci.com/gh/ahmetcelikezer/laravel-flag-system/tree/master.svg?style=svg)](https://circleci.com/gh/ahmetcelikezer/laravel-flag-system/tree/master)

>NOTE: Project is not ready to launch! Stable Version 1.0 will be released soon.

[Installation](#installation)<br>
[How to use](#how-to-use)<br>
&nbsp;&nbsp;[Creating Flag](#creating-new-flag)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Single Creation](#creating-single-flag)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Multiple Creation](#creating-multiple-flag)<br>
&nbsp;&nbsp;[Update Flag Title](#update-flag-title)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Update By Title](#update-flag-title-by-title)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Update By ID](#update-flag-title-by-id)<br>
&nbsp;&nbsp;[Disconntect Flag](#disconnect-flag)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Disconntect By Title](#disconnect-flag-by-title)<br>
&nbsp;&nbsp;&nbsp;&nbsp;[Disconntect By ID](#disconnect-flag-by-id)

## Installation # {#installation}

Add laravel-flag-system to your composer.json using this command bellow:

```sh
$ composer require ahmetcelikezer/laravel-flag-system
```

Next if you are using Laravel 5.5 or newer version, Laravel Package Auto-Discovery will add this service provider automaticly.

If you are using Laravel 5.4 or older version, you must add provider manually. Use the steps bellow:

 - Go to /config/app.php
 - Add ahmetcelikezer\laravelFlagSystem\FlagSystemServiceProvider::class, to 'providers' array
 
> Warning: Default table names are : "flags", "flag_relations", if you already created any table with one of theese names, you can change the table names on package_location/src/config.php

Right after, the package needs to create it's own migrations, so you must use Laravel's migrate command like bellow
```sh
$ php artisan migrate
```
---
## How to Use # {#how-to-use}
Let's give an axample to better explain:
For make easy to understand this package, we have an imaginary project which is based on e-commerce app. Now we will learn how to use this package on this project.


#### Creating a new Flag # {#creating-new-flag}
Creating a new flag is means like creating a rule or category or anything based on your imagination. And any table and it's record on your app's database can have one or more flags.

##### Single Creation # {#creating-single-flag}
> Note: All flag names are automatically will be lowercased and trimmed right before the insert by the system.

We want to crate "discount" flag to use with our products, so our code is will be similar this:

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->title = "discount";   // Define the flag name 
$flagsystem->create();             // Execute the create method
```

Now we can use "discount" flag anymore, also create method returns with boolean variable, if creation is successful it returns true, otherwise it will be returned with false.

##### Multiple Creation # {#creating-multiple-flag}
You also can create more than one flags at once.

Now we want to create 3 new flags to use, they will be "adult", "videogame", "phone".

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->title = ["adult", "vidaogame", "phone"];   // Define the flag names as array
$flagsystem->create();                                  // Execute the create method
```
This is acts just like Single Creation, just creates more than one flag.

---

#### Updating Flag Name # {#update-flag-title}
We can always made mistakes and we can to notice later... Fortunately it's not too late for anything, as you can see we made a mistake while we are creating "videogames" flag. It must be "videogames" but we just created "vidaogames". No worries we can update this.

##### By Flag Title # {#update-flag-title-by-title}

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag   = "vidaogame"; // Old(Target) Flag Title
$flagsystem->title  = "videogame"; // New Flag Title
$flagsytem->updateFlag();
```
##### By Flag ID # {#update-flag-title-by-id}

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id     = 3;            // Old(Target) Flag ID
$flagsystem->title  = "videogame";  // New Flag Title
$flagsytem->updateFlag();
```
---
#### Disconnect Flag # {#disconnect-flag}
Disconnect flag, removes targeted flag from every data includes it. However flag is wont be removed. You do not have to re-create flag.

For example we do not want to sell our products with any discount, so we want to clear every item from "discount" flag, we do not want to remove "discount" flag because we may want to sell any product with discount later. So we can use disconntectFlag method:

##### By Flag Title # {#disconnect-flag-by-title}

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag     = "discount";     // Flag ID
$flagsytem->disconnectFlag("products");
```

##### By Flag ID # {#disconnect-flag-by-id}

```php
<?php

use use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id     = 1;            // Flag ID
$flagsytem->disconnectFlag("products");
```
Now we do not have any products includes "discount" flag, but we still have the "discount" flag for use later or other tables.
