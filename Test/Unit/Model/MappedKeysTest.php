<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\ManagedHoliday\Test\Unit\Model;

use Alaa\XmlFeedModel\Model\MappedKeys;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class MappedKeysTest
 *
 * @package Alaa\ManagedHoliday\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class MappedKeysTest extends TestCase
{
    /**
     * @var MappedKeys|MockObject
     */
    protected $subject;

    /**
     * @var ScopeConfigInterface|MockObject
     */
    protected $scopeConfig;

    public function setUp()
    {
        parent::setUp();
        $this->scopeConfig = $this->getMockBuilder(\Magento\Framework\App\Config::class)
            ->disableOriginalConstructor()
            ->setMethods(['getValue'])
            ->getMock();

        $constructorArgs = [
            'file',
            $this->scopeConfig,
            new Json()
        ];

        $this->subject = $this->getMockBuilder(MappedKeys::class)
            ->setConstructorArgs($constructorArgs)
            ->setMethods(null)
            ->getMock();
    }

    public function testGetMappedKeys()
    {
        $this->scopeConfig->expects($this->any())
            ->method('getValue')
            ->willReturn(
                json_encode([['magento_attribute' => 'product_id', 'custom_attribute' => 'product']])
            );

        $this->assertTrue(\is_array($this->subject->getMappedKeys()));
        $this->assertTrue($this->subject->getMappedKeys() === ['product_id' => 'product']);
    }

    public function testGetMappedKeysEmptyArray()
    {
        $subject = $this->getMockBuilder(MappedKeys::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertEmpty($subject->getMappedKeys());
    }
}
