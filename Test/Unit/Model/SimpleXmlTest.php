<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types = 1);

namespace Alaa\XmlFeedModel\Test\Unit\Model;

use Alaa\XmlFeedModel\Model\SimpleXml;
use PHPUnit\Framework\TestCase;

/**
 * Class SimpleXmlTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SimpleXmlTest extends TestCase
{
    public function testAppend()
    {
        $person = new SimpleXml('<person/>');
        $person->addChild('firstname', 'jon');
        $person->addChild('lastname', 'doe');
        $person->addChild('email', 'jon.doe@example.com');

        $address = new SimpleXml('<address/>');
        $address->addChild('street', '123 queen street');
        $address->addChild('city', 'London');
        $address->addChild('postcode', 'bb1 aa2');
        $person->append($address);

        $this->assertEquals(
            (string) $person->asXML(),
            simplexml_load_file(__DIR__ . '/../_files/simplexml_example.xml')->asXML()
        );
    }
}
