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
 * PHP <5.4.0
 * Do not use this class directly - use HexUtil
 */
abstract class HexUtil53
{
    /**
     * Don't allow construction
     */
    protected function __construct(){}

    /**
     * Convert from hexadecimal to binary
     *
     * @param string $data hex string
     * @return binary the binary equivalent
     */
    public static function hex2bin($data)
    {
        if (strlen($data) % 2 == 1) {
            $data = '0' . $data;
        }

        return pack('H*', $data);
    }

    /**
     * Convert from binary to hexadecimal
     *
     * @param binary $data
     * @return string the hex equivalent
     */
    public static function bin2hex($data)
    {
        $ret = unpack('H*', $data);
        return $ret[1];
    }
}