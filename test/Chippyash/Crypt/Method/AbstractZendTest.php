<?php
/**
 * Crypt
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2015, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Test\Crypt\Method;


class AbstractZendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var \Chippyash\Crypt\Method\AbstractZend
     */
    protected $sut;

    /**
     * Mock
     * @var \Zend\Crypt\Symmetric\SymmetricInterface
     */
    protected $symmetricAdapter;

    protected function setUp()
    {
        $this->symmetricAdapter = $this->getMock('Zend\Crypt\Symmetric\SymmetricInterface');
        $this->symmetricAdapter->setKey('foofoo');
        $this->symmetricAdapter->expects($this->any())
            ->method('getKeySize')
            ->will($this->returnValue(6));

        $this->sut = $this->getMockForAbstractClass(
            'Chippyash\Crypt\Method\AbstractZend',
            array($this->symmetricAdapter)
        );
    }

    public function testYouCanEncryptUsingAZendAbstractMethod()
    {
        $this->symmetricAdapter->expects($this->once())
            ->method('encrypt')
            ->will($this->returnValue('foo'));
        $this->symmetricAdapter->expects($this->once())
            ->method('getAlgorithm')
            ->will($this->returnValue('foo'));

        $this->assertEquals(
            '84c25d9d9211932f7a69c3e84a090bade57b8c35dd6f8e1a66801dd889632ee8Zm9v',
            $this->sut->encrypt('bar', 'fudge')
        );
    }

    public function testYouCanDecryptUsingZendAbstractMethod()
    {
        $this->symmetricAdapter->expects($this->once())
            ->method('decrypt')
            ->will($this->returnValue('foo'));
        $this->symmetricAdapter->expects($this->once())
            ->method('getAlgorithm')
            ->will($this->returnValue('foo'));

        $this->assertEquals(
            'foo',
            $this->sut->decrypt('84c25d9d9211932f7a69c3e84a090bade57b8c35dd6f8e1a66801dd889632ee8Zm9v', 'fudge')
        );
    }

    public function testTheAbstractZendMethodProxiesUnknownMethodsToZendBlockCipher()
    {
        $this->assertNull($this->sut->getKey());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testCallingANonExistentMethodOnTheUnderlayingBlockCipherWillThrowAnException()
    {
        $this->sut->foo();
    }
}
