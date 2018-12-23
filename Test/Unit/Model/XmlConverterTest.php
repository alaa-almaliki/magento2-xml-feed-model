<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Model;

use Alaa\XmlFeedModel\Model\Subject;
use Alaa\XmlFeedModel\Model\XmlConverter;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlConverterTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class XmlConverterTest extends TestCase
{
    public function testConvert()
    {
        $person = new Subject(
            'person',
            [
            'firstname' => 'jon',
            'lastname' => 'doe',
            'email' => 'jon.doe@example.com',
            'no_scalar' => new \stdClass(),
            ]
        );

        $person->addAttribute('person', 'account_id', '100');

        $address = new Subject(
            'address',
            [
            'street' => '123 queen street',
            'city' => 'London',
            'postcode' => 'bb1 aa2'
            ]
        );

        $person->addChild($address);

        $xmlConverter = new XmlConverter();
        $personXml = $xmlConverter->convert($person);


        $this->assertEquals(
            (string) $personXml->asXML(),
            simplexml_load_file(__DIR__ . '/../_files/subject_xml.xml')->asXML()
        );
    }
}
