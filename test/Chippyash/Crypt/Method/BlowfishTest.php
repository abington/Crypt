<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Test\Crypt\Method;

use Chippyash\Crypt\Method\Blowfish;

class BlowfishTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var BlowFish
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new Blowfish();
    }

    public function testYouCanEncryptAndDecryptUsingTheBlowfishMethod()
    {
        $key = '1396b578-ae53-4614-ac3f-7f4a73a8b7ff';
        $plain = 'oh my Lord, I am disappearing under a sea of apathy';
        $this->assertEquals($plain, $this->sut->decrypt($this->sut->encrypt($plain, $key), $key));
    }
}
