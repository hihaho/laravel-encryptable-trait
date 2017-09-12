<?php

namespace HiHaHo\EncryptableTrait\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model as Eloquent;
use HiHaHo\EncryptableTrait\Encryptable;

class Payment extends Eloquent
{
    use Encryptable;

    protected $encryptable = [
        'creditcard',
    ];
}
