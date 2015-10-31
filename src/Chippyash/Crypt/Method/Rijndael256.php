<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Chippyash\Crypt\Method;

use Chippyash\Crypt\Exceptions\CryptException;

/**
 * Implements Rijndael-256 cryptography method
 *
 */
class Rijndael256 implements MethodInterface
{
    /**
     * @param mixed $data data to be encrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function encrypt($data, $key)
    {
        return $this->cryptastic($data, $key);
    }

    /**
     * @param mixed $data data to be decrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function decrypt($data, $key)
    {
        return $this->cryptastic($data, $key, false);
    }

    /**
     * encryption/decryption routine
     *
     * Data is serialized if encrypting and unserialized if decrypting
     *
     * @param mixed $data Data to encrypt/decrypt
     * @param string $key Encryption key
     * @param boolean $encrypt True to encrypt, false to decrypt
     *
     * @return False|blobtext Encrypted/decrypted content. False if unable to operate
     *
     * @throws CryptException
     * @throws \Exception
     *
     * @uses MCRYPT php extension
     * @author Andrew Johnson. The original author of Cryptastic. Unfortunately no link to original is on web
     */
    private function cryptastic($data, $key, $encrypt = true)
    {
        // Open cipher module
        if (!$td = mcrypt_module_open('rijndael-256', '', 'cfb', '')) {
            return false;
        }

        $ks = mcrypt_enc_get_key_size($td); // Required key size
        $key = substr(sha1($key), 0, $ks); // Harden / adjust length
        $ivs = mcrypt_enc_get_iv_size($td); // IV size
        if ($encrypt) {
            $iv = mcrypt_create_iv($ivs, MCRYPT_RAND); // Create IV, if encrypting
            $data = serialize($data);  // Serialize, if encrypting
        } else {
            $iv = substr($data, 0, $ivs); // Extract IV, if decrypting
            $data = substr($data, $ivs); // Extract data, if decrypting
        }

        // Initialize buffers
        if (mcrypt_generic_init($td, $key, $iv) !== 0) {
            return false;
        }

        if ($encrypt) {
            $data = $iv . mcrypt_generic($td, $data); // Prepend IV, if encrypting
        } else {
            $data = mdecrypt_generic($td, $data); // Perform decryption
        }

        mcrypt_generic_deinit($td); // Clear buffers
        mcrypt_module_close($td); // Close cipher module
        // Unserialize, if decrypting
        if (!$encrypt) {
            try {
                $data = @unserialize($data);
                if ($data === false) {
                    throw new CryptException('Invalid key');
                }
            } catch (\Exception $e) {
                throw new CryptException($e->getMessage(), $e->getCode(), $e);
            }
        }
        return $data;
    }
}