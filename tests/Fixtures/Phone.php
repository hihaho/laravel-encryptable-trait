<?php

namespace HiHaHo\EncryptableTrait\Tests\Fixtures;

use HiHaHo\EncryptableTrait\Encryptable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Phone extends Eloquent
{
    use Encryptable;

    protected $encryptable = [
        'imei',
    ];

    protected $dontThrowDecryptException = true;
}
