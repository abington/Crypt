<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Chippyash\Test\Crypt\Method;

use Chippyash\Crypt\Method\Rijndael256;

class Rijndael256Test extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var Rijndael256
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new Rijndael256();
    }

    public function testYouCanEncryptAndDecryptWithSameKey()
    {
        $plain = "foo bar baz";
        $key = "11e4356e-d6d7-448e-af37-817966215c34";
        $enc = $this->sut->encrypt($plain, $key);
        $dec = $this->sut->decrypt($enc, $key);
        $this->assertEquals($dec, $plain);
    }

    /**
     * @expectedException \Chippyash\Crypt\Exceptions\CryptException
     * @expectedExceptionMessage Invalid key
     */
    public function testDecryptingWithBadKeyThrowsAnException()
    {
        $plain = "foo bar baz";
        $key = "11e4356e-d6d7-448e-af37-817966215c34";
        $badKey = "3a3ca16a-13d0-447f-8545-7e5728c51183";
        $this->sut->decrypt($this->sut->encrypt($plain, $key), $badKey);
    }

    public function testYouCanEncryptSerializableObjects()
    {
        $plain = new \stdClass();
        $plain->foo = 'bar';
        $key = "11e4356e-d6d7-448e-af37-817966215c34";
        $enc = $this->sut->encrypt($plain, $key);
        $dec = $this->sut->decrypt($enc, $key);
        $this->assertEquals($dec, $plain);
    }
}
