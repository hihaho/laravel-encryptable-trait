<?php

namespace HiHaHo\EncryptableTrait;

use Illuminate\Contracts\Encryption\DecryptException;

/**
 * Trait Encryptable
 * This trait encrypts all your fields (defined in $this->encryptable) before saving it to the database.
 */
trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptable)) {
            try {
                return decrypt($value);
            } catch (DecryptException $e) {
                if (isset($this->dontThrowDecryptException) && $this->dontThrowDecryptException === true) {
                    return;
                }
                throw $e;
            }
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
}
