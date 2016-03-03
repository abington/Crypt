<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Chippyash\Crypt;

use Chippyash\Crypt\Exceptions\CryptException;
use Chippyash\Crypt\Method\MethodInterface;
use Chippyash\Type\BoolType;
use Chippyash\Type\String\StringType;

/**
 * Straightforward encrypt/decrypt methods
 *
 * Provides a machine mac address seedable encrypt/decrypt pair
 * Mac address support is linux based OS only at present
 */
class Crypt
{
    /**
     * Encryption seed string
     * @var string
     */
    protected $seed;

    /**
     * @var MethodInterface
     */
    protected $method;

    /**
     * Enforce use of machine mac address in cryptography
     *
     * @var boolean
     */
    private $useMac = false;

    /**
     * Constructor
     *
     * @param StringType $seed Encryption key seed.
     * @param MethodInterface $method.
     * @throws CryptException
     */
    public function __construct(StringType $seed, MethodInterface $method)
    {
        if (!extension_loaded('mcrypt')) {
            throw new CryptException('mcrypt extension is not loaded. Please install.');
        }
        $this->seed = $seed();
        $this->method = $method;
        $this->setUseMacAddress(new BoolType(true));
    }

    /**
     * Use the server's mac address if available in cryptography
     * Default is on
     *
     * @param BoolType $flag
     * @return \Chippyash\Crypt\Crypt Fluent Interface
     */
    public function setUseMacAddress(BoolType $flag)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //cannot use mac address on windows server
            return;
        }

        $this->useMac = $flag();

        return $this;
    }

    /**
     * Encrypt data using machine specific encryption
     *
     * @param mixed $data Data to be encrypted
     * @param BoolType $base64Encode Default == true
     * @return mixed|False Encrypted data. False if unable to encrypt
     */
    public function mcEncrypt($data, BoolType $base64Encode = null)
    {
        $enc = $this->method->encrypt($data, $this->getCryptKey());
        $doEncode = is_null($base64Encode) ? true : $base64Encode();

        if ($doEncode && $enc !== false) {
            return base64_encode($enc);
        } else {
            return $enc;
        }
    }

    /**
     * Unencrypt data using machine specific encryption
     *
     * @param mixed $enc data to be decrypted
     * @param BoolType $base64Decode Default == true
     * @return mixed The decrypted data
     */
    public function mcDecrypt($enc, BoolType $base64Decode = null)
    {
        if (empty($enc)) {
            return $enc; //nothing to do
        }
        $doDecode = is_null($base64Decode) ? true : $base64Decode();
        if ($doDecode) {
            $enc = base64_decode($enc);
        }
        $data = $this->method->decrypt($enc, $this->getCryptKey());

        return $data;
    }

    /**
     * Get the encryption key
     *
     * Encryption key is made up of the supplied seed and optionally, the machine MAC address
     *
     * @return string The cryptkey
     */
    private function getCryptKey()
    {
        $cryptkey = (string) $this->seed;
        if ($this->useMac) {
            $mac = $this->getMac();
            if ($mac !== false) {
                $cryptkey .= $mac;
            }
        }

        return $cryptkey;
    }

    /**
     * Get machine MAC address - linux only
     *
     * @todo create variant for windows
     *
     * @return string|boolean mac address else false if not found
     */
    private function getMac()
    {
        if (!`which ifconfig`) {
            return false;
        }
        $cmd = "ifconfig"; //linux only
        $output = array();
        $ret = exec($cmd, $output);
        $found = false;
        foreach ($output as $line) {
            $p = strpos($line, 'HWaddr');
            if ($p !== false) {
                $found = $line;
                break;
            }
        }
        if ($found !== false) {
            $mac = substr($found, $p + 7);
        } else {
            $mac = false;
        }
        return $mac;
    }
}