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
 * Class AddAttributeTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class AddAttributeTest extends TestCase
{
    public function testAddAttribute()
    {
        $subject = new Subject('order', ['total' => '34.99']);
        $subject->addAttribute('order', 'order_id', '1');
        $subject->addAttribute('order', 'customer_reference', '27');

        $this->assertEquals(
            ['order_id' => '1', 'customer_reference' => '27'],
            $subject->getAttributes('order')
        );
    }

    public function testAddAttributeEmptyResults()
    {
        $subject = new Subject('order', ['total' => '34.99']);
        $this->assertEmpty($subject->getAttributes('order'));
    }
}
