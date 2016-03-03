<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Crypt\Method;

use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\SymmetricInterface;

/**
 * Abstraction for using Zend BlockCipher components
 * The __call method proxies to BlockCipher
 *
 */
abstract class AbstractZend implements MethodInterface
{
    /**
     * @var BlockCipher
     */
    protected $zendCrypt;

    /**
     * Constructor
     * @param SymmetricInterface $cypher
     */
    public function __construct(SymmetricInterface $cypher)
    {
        $this->zendCrypt = new BlockCipher($cypher);
    }

    /**
     * @param mixed $data data to be encrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function encrypt($data, $key)
    {
        return $this->zendCrypt
            ->setKey($key)
            ->encrypt($data);
    }

    /**
     * @param mixed $data data to be decrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function decrypt($data, $key)
    {
        return $this->zendCrypt
            ->setKey($key)
            ->decrypt($data);
    }

    /**
     * Proxy to underlying Zend BlockCipher
     *
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        if (!method_exists($this->zendCrypt, $method)) {
            throw new \BadMethodCallException("non existent method: {$method}");
        }

        return call_user_func_array(array($this->zendCrypt, $method), $params);
    }
}