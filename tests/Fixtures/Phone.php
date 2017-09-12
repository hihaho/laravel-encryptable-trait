<?php

namespace HiHaHo\EncryptableTrait\Tests\Fixtures;

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
