<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Crypt\Method;


use Zend\Crypt\Symmetric\Mcrypt;

/**
 * Blowfish encryption
 */
class Blowfish extends AbstractZend
{

    public function __construct()
    {
        parent::__construct(new Mcrypt(array(
            'algo' => 'blowfish'
        )));
    }

}