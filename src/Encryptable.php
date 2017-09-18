<?php

namespace HiHaHo\EncryptableTrait;

use Illuminate\Contracts\Encryption\DecryptException;

/**
 * Trait Encryptable
 * This trait encrypts all your fields (defined in $this->encryptable) before saving it to the database.
 */
trait Encryptable
{
    /**
     * Checks if the attribute is encryptable.
     * @param $key
     * @return bool
     */
    private function isEncryptable($key)
    {
        return in_array($key, $this->encryptable);
    }

    /**
     * Decrypts a value.
     * @param $value
     * @return string|void decrypted value
     */
    private function decrypt($value)
    {
        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            if (isset($this->dontThrowDecryptException) && $this->dontThrowDecryptException === true) {
                return;
            }
            throw $e;
        }
    }

    /**
     * Encrypts a value.
     * @param $value
     * @return string
     */
    private function encrypt($value)
    {
        return encrypt($value);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($this->isEncryptable($key)) {
            return $this->decrypt($value);
        }

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->isEncryptable($key)) {
            $value = $this->encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get an attribute array of all arrayable attributes.
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        $attributes = parent::getArrayableAttributes();

        foreach ($attributes as $key => $attribute) {
            if ($this->isEncryptable($key)) {
                $attributes[$key] = $this->decrypt($attribute);
            }
        }

        return $attributes;
    }
}
