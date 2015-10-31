<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Chippyash\Crypt\Method\HexUtil;

if (version_compare(PHP_VERSION, '5.4.0', 'lt')) {
    class_alias('Chippyash\Crypt\Method\HexUtil\HexUtil53', 'Chippyash\Crypt\Method\HexUtil\HexImplementation');
} else {
    class_alias('Chippyash\Crypt\Method\HexUtil\HexUtil54', 'Chippyash\Crypt\Method\HexUtil\HexImplementation');
}

/**
 * hex digit utils
 */
abstract class HexUtil extends  HexImplementation
{
    /**
     * Don't allow construction
     */
    protected function __construct(){}

    /**
     * Convert a binary into binary string
     *
     * @param binary $binary
     * @return string  binary representation string of 0 and 1
     */
    public static function bin2char($binary)
    {
        return base_convert(self::bin2hex($binary), 16, 2);
    }
}
