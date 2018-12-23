<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Model\Parser;

use Alaa\XmlFeedModel\Model\Parser\PhpArrayParser;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class PhpArrayParserTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model\Parser
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class PhpArrayParserTest extends TestCase
{
    /**
     * @var MockObject|PhpArrayParser
     */
    protected $subject;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->subject = new PhpArrayParser(__DIR__ . '/../../_files/array.php');
    }

    public function testParse()
    {
        $parsedArray = [
            'order' => 'mapper/mapped_fields/order',
            'order.customer' => 'mapper/mapped_fields/customer',
            'order.customer.customer_address' => 'mapper/mapped_fields/customer_address',
            'order.items' => '',
            'order.items.item' => 'mapper/mapped_fields/item',
        ];

        $this->assertTrue(\is_array($this->subject->parse()));
        $this->assertEquals($parsedArray, $this->subject->parse());
    }
}
