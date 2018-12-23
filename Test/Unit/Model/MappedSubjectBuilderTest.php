<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Model;

use Alaa\XmlFeedModel\Model\MappedSubjectBuilder;
use Alaa\XmlFeedModel\Model\Subject;
use Alaa\XmlFeedModel\Model\SubjectMapper;
use Alaa\XmlFeedModel\Model\Validator\FileExists;
use Alaa\XmlFeedModel\Test\Unit\MockTrait;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class MappedSubjectBuilderTest
 *
 * @package Alaa\ManagedHoliday\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class MappedSubjectBuilderTest extends TestCase
{
    use MockTrait;
    /**
     * @var MockObject|MappedSubjectBuilder
     */
    protected $subject;

    /**
     * @var SubjectMapper|MockObject
     */
    protected $mapper;

    protected function setUp()
    {
        parent::setUp();

        $this->mapper = $this->getMock(SubjectMapper::class, ['getMappedSubject']);
        $fileExists = $this->createMock(FileExists::class);

        $fileExistsFactory = $this->createMock(\Alaa\XmlFeedModel\Model\Validator\FileExistsFactory::class);
        $fileExistsFactory->expects($this->any())
            ->method('create')
            ->willReturn($fileExists);

        $subjectMapperFactory = $this->createMock(\Alaa\XmlFeedModel\Model\SubjectMapperFactory::class);
        $subjectMapperFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->mapper);

        $this->subject = $this->getMock(MappedSubjectBuilder::class, null, [$subjectMapperFactory, $fileExistsFactory]);
    }

    public function testBuild()
    {
        $root = new Subject('person');
        $root->setData(['name' => 'Jon Doe', 'email' => 'jon.doe@example.com']);
        $address = new Subject('address');
        $address->addData(['street' => '123 queen road', 'city' => 'Manchester', 'postcode' => 'bb1 3cc']);
        $root->addChild($address);

        $this->mapper->expects($this->any())
            ->method('getMappedSubject')
            ->willReturn($root);

        $fileExists = $this->getMock(FileExists::class, null, [dirname(dirname(__FILE__)). '/_files/array.php']);
        $fileExistsFactory = $this->createMock(\Alaa\XmlFeedModel\Model\Validator\FileExistsFactory::class);
        $fileExistsFactory->expects($this->any())
            ->method('create')
            ->with(['filename' => dirname(dirname(__FILE__)). '/_files/array.php'])
            ->willReturn($fileExists);

        $subjectMapperFactory = $this->createMock(\Alaa\XmlFeedModel\Model\SubjectMapperFactory::class);
        $subjectMapperFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->mapper);

        $this->subject = $this->getMock(MappedSubjectBuilder::class, null, [$subjectMapperFactory, $fileExistsFactory]);

        $mappedSubject = $this->subject->build(dirname(dirname(__FILE__)). '/_files/array.php', $root);
        $this->assertInstanceOf(Subject::class, $mappedSubject);
        $this->assertEquals($mappedSubject, $root);
    }

    /**
     * @expectedException \Alaa\XmlFeedModel\Exception\FileNotExistsException
     */
    public function testBuildThrowException()
    {
        $this->subject->build('not/exist/file', new Subject());
        $this->subject->expects($this->never())->method('map');
    }
}
