<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model\Subject;

use Alaa\XmlFeedModel\Model\Subject;
use PHPUnit\Framework\TestCase;

/**
 * Class GetNodeNameTest
 *
 * @package Alaa\XmlFeedModel\Model\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class GetNodeNameTest extends TestCase
{
    public function testGetNodeNameBy()
    {
        $subject = new Subject('order', ['total' => '34.99']);

        $subject1 = new Subject();
        $subject1->setNodeName('order');

        $this->assertEquals('order', $subject->getNodeName());
        $this->assertEquals(['total' => '34.99'], $subject->getData());
        $this->assertEquals('34.99', $subject->getData('total'));
        $this->assertEquals('order', $subject1->getNodeName());
    }
}
