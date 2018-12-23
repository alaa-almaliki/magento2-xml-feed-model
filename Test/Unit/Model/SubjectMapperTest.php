<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit\Model;

use Alaa\XmlFeedModel\Model\MappedKeys;
use Alaa\XmlFeedModel\Model\MappedKeysInterfaceFactory;
use Alaa\XmlFeedModel\Model\Parser\ParserInterfaceFactory;
use Alaa\XmlFeedModel\Model\Parser\PhpArrayParser;
use Alaa\XmlFeedModel\Model\Subject;
use Alaa\XmlFeedModel\Model\SubjectMapper;
use Alaa\XmlFeedModel\Subject\Transformer;
use Alaa\XmlFeedModel\Subject\TransformerInterfaceFactory;
use Alaa\XmlFeedModel\Test\Unit\MockTrait;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class SubjectMapperTest
 *
 * @package Alaa\XmlFeedModel\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SubjectMapperTest extends TestCase
{
    use MockTrait;

    /**
     * @var MockObject|SubjectMapper
     */
    protected $subject;

    /**
     * @var MockObject|PhpArrayParser
     */
    protected $parser;

    /**
     * @var MappedKeys|MockObject
     */
    protected $mappedKeys;

    /**
     * @var Transformer|MockObject
     */
    protected $transformer;

    protected function setUp()
    {
        parent::setUp();

        $this->parser = $this->getMock(PhpArrayParser::class, ['parse']);
        $parserFactory = $this->createMock(ParserInterfaceFactory::class);
        $parserFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->parser);

        $this->mappedKeys = $this->getMock(MappedKeys::class, ['getMappedKeys']);
        $mappedKeysFactory = $this->createMock(MappedKeysInterfaceFactory::class);
        $mappedKeysFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->mappedKeys);

        $this->transformer = $this->getMock(Transformer::class, ['transform']);
        $transformFactory = $this->createMock(TransformerInterfaceFactory::class);
        $transformFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->transformer);

        $constructorArgs = [
            'path/to/file',
            $parserFactory,
            $mappedKeysFactory,
            $transformFactory
        ];
        $this->subject = $this->getMock(SubjectMapper::class, null, $constructorArgs);
    }

    public function testGetMappedSubject()
    {
        $this->parser->expects($this->any())
            ->method('parse')
            ->willReturn(['order' => 'xml/path/to/config']);

        $this->mappedKeys->expects($this->any())
            ->method('getMappedKeys')
            ->willReturn(
                [
                'entity_id' => 'order_id'
                ]
            );

        $this->transformer->expects($this->any())
            ->method('transform')
            ->willReturn(new Subject('order', ['order_id' => '1']));

        $this->assertInstanceOf(
            Subject::class,
            $this->subject->getMappedSubject(new Subject('order', ['entity_id' => 1]))
        );
    }

    public function testGetMappedSubjectNoMatchedSubjectPath()
    {
        $this->parser->expects($this->any())
            ->method('parse')
            ->willReturn(['order' => 'xml/path/to/config']);

        $this->mappedKeys->expects($this->never())->method('getMappedKeys');
        $this->transformer->expects($this->never())->method('transform');
        $this->assertNull($this->subject->getMappedSubject(new Subject('customer')));
    }

    public function testGetMappedSubjectNoParsedData()
    {
        $this->parser->expects($this->any())
            ->method('parse')
            ->willReturn([]);

        $this->mappedKeys->expects($this->never())->method('getMappedKeys');
        $this->transformer->expects($this->never())->method('transform');
        $this->assertNull($this->subject->getMappedSubject(new Subject('order')));
    }
}
