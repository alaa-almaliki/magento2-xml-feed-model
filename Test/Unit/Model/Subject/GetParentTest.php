<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Model\Subject;

use Alaa\XmlFeedModel\Model\Subject;
use PHPUnit\Framework\TestCase;

/**
 * Class GetParentTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class GetParentTest extends TestCase
{
    public function testGetPath()
    {
        $order = new Subject('order');
        $customer = new Subject('customer');
        $address = new Subject('address');

        $customer->addChild($address);
        $order->addChild($customer);

        $this->assertTrue($customer->hasParent());
        $this->assertTrue($address->hasParent());
        $this->assertInstanceOf(Subject::class, $customer->getParent());
        $this->assertInstanceOf(Subject::class, $address->getParent());
        $this->assertFalse($order->hasParent());
        $this->assertNull($order->getParent());
    }
}
