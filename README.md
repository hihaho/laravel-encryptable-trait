Laravel Encryptable Trait
=========================

[![License](https://poser.pugx.org/hihaho/laravel-encryptable-trait/license)](https://packagist.org/packages/hihaho/laravel-encryptable-trait)

> [!WARNING]
># No longer maintained
>We no longer use this package and will not maintain it. Please feel free to fork it and maintain it yourself.
>
>Consider migrating to Laravel encryption features which we added since this package was created.
>
>This package uses serialized encryption, while the Laravel encryption casts unserialized encryption.
>You can upgrade uses of this package to custom casts, e.g. by implementing `Illuminate\Contracts\Database\Eloquent\Castable` on a data object used as cast.

-----

### Introduction

This trait encrypts all your fields (defined in `$this->encryptable`) before saving it to the database.
It makes it extremely easy to treat certain fields as encryptable by automatically encrypting and decrypting the values.

### Install

Simply add the following line to your ```composer.json``` and run ```composer update```
```
"hihaho/laravel-encryptable-trait": "^v4.0"
```
Or use composer to add it with the following command
```bash
composer require hihaho/laravel-encryptable-trait
```

#### Requirements
- illuminate/encryption ^10.0 or ^11.0
- PHP 8.1, 8.2 or 8.3

### Usage
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

#### DecryptException
This package will throw a DecryptException (the default Laravel one: ```Illuminate\Contracts\Encryption\DecryptException```).
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

### Contributors
- [Robert Boes](https://github.com/robertboes)
- [Mart de Graaf](https://github.com/martdegraaf)
- [Sander Muller](https://github.com/SanderMuller)
- [ivinteractive](https://github.com/ivinteractive) / [iv-craig](https://github.com/iv-craig)
