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
 * Class AddChildTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class AddChildTest extends TestCase
{

    public function testAddChild()
    {
        $order = new Subject('order');
        $customer = new Subject('customer');
        $address = new Subject('address');

        $order->addChild($customer);
        $customer->addChild($address);

        $this->assertInstanceOf(Subject::class, $order->getChild('customer'));
        $this->assertInstanceOf(Subject::class, $customer->getChild('address'));
        $this->assertTrue($order->hasChildren());
        $this->assertTrue($customer->hasChildren());
        $this->assertTrue(\is_array($order->getChildren()));
        $this->assertTrue(\is_array($customer->getChildren()));
    }

    /**
     * @expectedException \Alaa\XmlFeedModel\Exception\SubjectException
     */
    public function testGetChildWithException()
    {
        $order = new Subject('order');
        $this->assertInstanceOf(Subject::class, $order->getChild('customer'));
    }

    /**
     * @expectedException \Alaa\XmlFeedModel\Exception\SubjectException
     */
    public function testAddChildWithException()
    {
        $order = new Subject('order');
        $customer = new Subject('customer');

        $order->addChild($customer);
        $order->addChild($customer);
    }
}
