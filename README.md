# Laravel Flag System - Development Test
[![CircleCI](https://circleci.com/gh/ahmetcelikezer/laravel-flag-system/tree/master.svg?style=svg)](https://circleci.com/gh/ahmetcelikezer/laravel-flag-system/tree/master)
![Version](https://img.shields.io/badge/version-alpha-orange.svg)
![Version](https://img.shields.io/badge/usable-not%20ready-red.svg)


>NOTE: Project is not ready to launch! Stable Version 1.0 will be released soon.

* [Installation](#Installation)
* [How to use](#how-to-use)
    * [Creating Flag](#creating-a-new-flag)
        * [Single Creation](#single-creation)
        * [Multiple Creation](#multiple-creation)
    * [Update Flag Title](#updating-flag-name)
        * [Update By Title](#by-flag-title)
        * [Update By ID](#by-flag-id)
    * [Remove Flag](#remove-flag)
        * [Remove by Title](#remove-flag-by-title)
        * [Remove by ID](#remove-flag-by-id)
    * [Flag Relations](#flag-relations)
        * [Add Flag to Data](#add-flag-to-data)
            * [Add Flag to Data by Title](#add-flag-to-data-by-title)
            * [Add Flag to Data by ID](#add-flag-to-data-by-id)
            * [Add Multiple Flag to Data](#add-multiple-flags-to-data)
    * [Disconnect Flag](#disconnect-flag)
        * [Disconnect By Title](#disconnect-by-flag-title)
        * [Disconnect All By Title](#disconnect-all-by-title)
        * [Disconnect By ID](#disconnect-by-flag-id)
        * [Disconnect All By ID](#disconnect-all-by-id)
    * [Controls](#controls)
        * [Query Data for Specific Flag](#query-data-for-specific-flag)


## Installation
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
## How to Use
Let's give an axample to better explain:
For make easy to understand this package, we have an imaginary project which is based on e-commerce app. Now we will learn how to use this package on this project.


#### Creating a new Flag
Creating a new flag is means like creating a rule or category or anything based on your imagination. And any table and it's record on your app's database can have one or more flags.

##### Single Creation
> Note: All flag names are automatically will be lowercased and trimmed right before the insert by the system.

We want to crate "discount" flag to use with our products, so our code is will be similar this:

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->title = "discount";   // Define the flag name 
$flagsystem->create();             // Execute the create method
```

Now we can use "discount" flag anymore, also create method returns with boolean variable, if creation is successful it returns true, otherwise it will be returned with false.

##### Multiple Creation
You also can create more than one flags at once.

Now we want to create 3 new flags to use, they will be "adult", "videogame", "phone".

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->title = ["adult", "vidaogame", "phone"];   // Define the flag names as array
$flagsystem->create();                                  // Execute the create method
```
This is acts just like Single Creation, just creates more than one flag.

---

#### Updating Flag Name
We can always made mistakes and we can to notice later... Fortunately it's not too late for anything, as you can see we made a mistake while we are creating "videogames" flag. It must be "videogames" but we just created "vidaogames". No worries we can update this.

##### By Flag Title

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag   = "vidaogame"; // Old(Target) Flag Title
$flagsystem->title  = "videogame"; // New Flag Title
$flagsytem->updateFlag();
```
##### By Flag ID

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id     = 3;            // Old(Target) Flag ID
$flagsystem->title  = "videogame";  // New Flag Title
$flagsytem->updateFlag();
```
---
#### Remove Flag
Removes the selected flag, also it runs disconnectAll method first by itself. So after delete succeed no data have that flag anymore.
>You can not undo this command, after removing flag will be unusable and completely deleted.

##### Remove Flag by Title
```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag = 'im useless flag';
$flagsystem->removeFlag(); // This will remove the flag
```

##### Remove Flag by ID
```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id = 7;
$flagsystem->removeFlag(); // This will remove the flag
```
---
### Flag Relations
Flag relations is management between flags and user table's data.

#### Add Flag to Data
This method adds flag or flags to any data from any table. For example, we will add discount to an product(record) on "products" table.

##### Add Flag to Data by Title

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;

$flagsystem->flag   = "discount";   // Flag name to add
$flagsystem->target = "products";   // Target data table name
$flagsystem->dataID = 434;          // Target data id in table

$flagsystem->addFlag();             // This will add the flag to data
```
##### Add Flag to Data by ID

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;

$flagsystem->id     = 1;            // Flag id to add
$flagsystem->target = "products";   // Target data table name
$flagsystem->dataID = 434;          // Target data id in table

$flagsystem->addFlag();             // This will add the flag to data

```
##### Add Multiple Flags to Data
You can add multiple flags at once as an array, it is just like the example above. The difference is instead of defining the parameters as an object, you can define that parameters in the array. While you define the target flag, you can define it as id or title in the same array.
```php
<?php
use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;

$flagsystem->addFlag([
    ['id' => 1, 'target' => 'products', 'dataID' => 434],           // Add Flag by ID
    ['flag' => 'discount', 'target' => 'products', 'dataID' => 38], // Add Flag by Title
    ['flag' => 'new', 'target'=>'users', 'dataID'=>8],              // Add Flag by Title
]);
```
---
#### Disconnect Flag
Disconnect flag, removes targeted flag from every data includes it. However flag is wont be removed. You do not have to re-create flag.

For example we do not want to sell our products with any discount, so we want to clear every item from "discount" flag, we do not want to remove "discount" flag because we may want to sell any product with discount later. So we can use disconntectFlag method:

##### Disconnect by Flag Title

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag = "discount";     // Flag ID
$flagsytem->disconnectFlag("products");
```

##### Disconnect by Flag ID

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id = 1;    // Flag ID
$flagsytem->disconnectFlag("products");
```
Now we do not have any products includes "discount" flag, but we still have the "discount" flag for use later or other tables.

###### Disconnect All by ID
Disconnects flag from every data and table it's included by them. For example;
We have a "new" flag to use on "users" table for tag the new users, "comments" table for tag new comments and "products" table for tag newest products. And we do not want to use "new" flag for any data on our APP. So this command will remove flag from all relations with the all data and all table.

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->id = 8;
$flagsystem->disconnectAll(); // This will disconnect the flag
```
###### Disconnect All by Title

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;
$flagsystem->flag = 'new';
$flagsystem->disconnectAll(); // This will disconnect the flag
```
---

### Controls
#### Query Data for Specific Flag

```php
<?php

use ahmetcelikezer\laravelFlagSystem\classes\FlagSystem; // Required library

// Create a new FlagSystem object
$flagsystem = new FlagSystem;

$flagsystem->flag   = 'adult';      // Flag title to search
$flagsystem->target = 'products';   // Search target table
$flagsystem->dataID = 765;          // Search target record id

// hasFlag method returns boolean

if($flagsystem->hasFlag()){
    echo 'Product 765 has adult flag';
}
```

You can also query with flag id
```php
<?php
// Create a new FlagSystem object
$flagsystem->id   = 8;      // Flag id to search
```
---