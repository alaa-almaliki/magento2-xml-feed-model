<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Subject;

use Alaa\XmlFeedModel\Model\Subject;
use Alaa\XmlFeedModel\Subject\Transformer;
use PHPUnit\Framework\TestCase;

/**
 * Class TransformerTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class TransformerTest extends TestCase
{
    public function testTransform()
    {
        $person = new Subject(
            'person',
            [
                'FirstName' => 'jon',
                'LastName' => 'doe',
                'Email' => 'jon.doe@example.com'
            ]
        );
        $person->addAttribute('person', 'account_id', '100');

        $personTransformer = new Transformer(
            [
                'FirstName' => 'firstname',
                'LastName' => 'lastname',
                'Email' => 'email',
            ]
        );

        $transformedPerson = $personTransformer->transform($person);

        foreach (['firstname', 'lastname', 'email'] as $key) {
            $this->assertTrue($transformedPerson->hasData($key));
        }

        $this->assertTrue(\is_array($transformedPerson->getAttributes('person')));
        $this->assertEquals(['account_id' => '100'], $transformedPerson->getAttributes('person'));
    }
}
