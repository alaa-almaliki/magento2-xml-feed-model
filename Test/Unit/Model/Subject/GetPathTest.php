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
 * Class GetPathTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class GetPathTest extends TestCase
{
    public function testGetPath()
    {
        $order = new Subject('order');
        $customer = new Subject('customer');
        $address = new Subject('address');

        $customer->addChild($address);
        $order->addChild($customer);

        $this->assertEquals('order', $order->getPath());
        $this->assertEquals('order.customer', $customer->getPath());
        $this->assertEquals('order.customer.address', $address->getPath());
    }
}
