<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Crypt\Method;

/**
 * Interface for adding encryption methods
 *
 */
interface MethodInterface
{
    /**
     * @param mixed $data data to be encrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function encrypt($data, $key);

    /**
     * @param mixed $data data to be decrypted
     * @param mixed $key encryption key
     *
     * @return mixed|false
     */
    public function decrypt($data, $key);

}