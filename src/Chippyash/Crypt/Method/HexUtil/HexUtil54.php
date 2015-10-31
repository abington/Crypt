<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Chippyash\Crypt\Method\HexUtil;

/**
 * hex digit utils
 * PHP >=5.4.0
 * Do not use this class directly - use HexUtil
 */
abstract class HexUtil54
{
    public static function hex2bin($data)
    {
        if (strlen($data) % 2 == 1) {
            $data = '0' . $data;
        }

        return \hex2bin($data);
    }

    public static function bin2hex($data)
    {
        return \bin2hex($data);
    }
}