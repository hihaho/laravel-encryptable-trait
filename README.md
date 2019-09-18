Laravel Encryptable Trait
=========================

[![Build Status](https://travis-ci.org/HiHaHo-Interactive-Video/laravel-encryptable-trait.svg?branch=master)](https://travis-ci.org/HiHaHo-Interactive-Video/laravel-encryptable-trait)
[![StyleCI](https://styleci.io/repos/103246398/shield?branch=master&style=flat)](https://styleci.io/repos/103246398)
[![Code Climate](https://codeclimate.com/github/HiHaHo-Interactive-Video/laravel-encryptable-trait/badges/gpa.svg)](https://codeclimate.com/github/HiHaHo-Interactive-Video/laravel-encryptable-trait)
[![Latest Stable Version](https://poser.pugx.org/hihaho/laravel-encryptable-trait/v/stable)](https://packagist.org/packages/hihaho/laravel-encryptable-trait)
[![Total Downloads](https://poser.pugx.org/hihaho/laravel-encryptable-trait/downloads)](https://packagist.org/packages/hihaho/laravel-encryptable-trait)
[![Latest Unstable Version](https://poser.pugx.org/hihaho/laravel-encryptable-trait/v/unstable)](https://packagist.org/packages/hihaho/laravel-encryptable-trait)
[![License](https://poser.pugx.org/hihaho/laravel-encryptable-trait/license)](https://packagist.org/packages/hihaho/laravel-encryptable-trait)
[![Dependency Status](https://www.versioneye.com/user/projects/59b7c7150fb24f0032e40d4e/badge.svg?style=flat)](https://www.versioneye.com/user/projects/59b7c7150fb24f0032e40d4e)

This trait encrypts all your fields (defined in $this->encryptable) before saving it to the database.
It makes it extremely easy to treat certain fields as encryptable by automatically encrypting and decrypting the values.

# Photoware

This package is free to use, but inspired by [Spaties' Poscardware](https://spatie.be/en/opensource/postcards) we'd love to see where 
where this package is being developed. A photo of an important landmark in your area would be highly appreciated.

Our email address is [photoware@hihaho.com](mailto:photoware@hihaho.com)

# Install

Simply add the following line to your ```composer.json``` and run ```composer update```
```
"hihaho/laravel-encryptable-trait": "^v1.3"
```
Or use composer to add it with the following command
```bash
composer require "hihaho/laravel-encryptable-trait:^v1.3"
```

## Requirements
- illuminate/encryption 5.5+ (Laravel 5.5+)
- PHP 7.1+

# Usage
Simply add the trait to your models and set the ```$encryptable``` to an array of values that need to be encrypted.

```php
<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HiHaHo\EncryptableTrait\Encryptable;

class Phone extends Eloquent
{
    use Encryptable;

    protected $encryptable = [
        'imei',
    ];
}
```

## DecryptException
This package will thrown a DecryptException (the default Laravel one: ```Illuminate\Contracts\Encryption\DecryptException```).
You can however set ```$dontThrowDecryptException``` to true to ignore the exception. 
If the value can't be decrypted it will just return null.

```php
<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HiHaHo\EncryptableTrait\Encryptable;

class Phone extends Eloquent
{
    use Encryptable;

    protected $encryptable = [
        'imei',
    ];
    
    protected $dontThrowDecryptException = true;
}
```

If the database contains an invalid value, this will return null.

````php
$phone = Phone::find(1);
$phone->imei; //Will return null
````

# Contributors
- [Robert Boes](https://github.com/robertboes)
- [Mart de Graaf](https://github.com/martdegraaf)
- [Sander Muller](https://github.com/SanderMuller)
- [ivinteractive](https://github.com/ivinteractive) / [iv-craig](https://github.com/iv-craig)
