<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Alaa\XmlFeedModel\Model\Parser\ParserInterface;
use Alaa\XmlFeedModel\Model\Parser\ParserInterfaceFactory;
use Alaa\XmlFeedModel\Subject\TransformerInterface;
use Alaa\XmlFeedModel\Subject\TransformerInterfaceFactory;

/**
 * Class SubjectMapper
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SubjectMapper
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var \Alaa\XmlFeedModel\Model\MappedKeysInterfaceFactory
     */
    protected $mappedKeysFactory;

    /**
     * @var TransformerInterfaceFactory
     */
    protected $transformerFactory;

    /**
     * @var string
     */
    protected $filename;

    /**
     * SubjectMapper constructor.
     *
     * @param string                      $filename
     * @param ParserInterfaceFactory      $parserFactory
     * @param MappedKeysInterfaceFactory  $mappedKeysFactory
     * @param TransformerInterfaceFactory $transformerFactory
     */
    public function __construct(
        string $filename,
        ParserInterfaceFactory $parserFactory,
        MappedKeysInterfaceFactory $mappedKeysFactory,
        TransformerInterfaceFactory $transformerFactory
    ) {
        $this->mappedKeysFactory = $mappedKeysFactory;
        $this->transformerFactory = $transformerFactory;
        $this->parser = $parserFactory->create(['filename' => $filename]);
        $this->filename = $filename;
    }

    /**
     * @param null|Subject $subject
     * @return Subject
     */
    public function getMappedSubject(Subject $subject)
    {
        foreach ($this->parser->parse() as $path => $xmlConfigPath) {
            if ($subject->getPath() === $path) {
                $mappedKeys = $this->mappedKeysFactory
                    ->create(['xmlPath' => $xmlConfigPath])
                    ->getMappedKeys();
                /** @var TransformerInterface $transformer */
                $transformer = $this->transformerFactory->create(['mappedKeys' => $mappedKeys]);
                return $transformer->transform($subject);
            }
        }

        return null;
    }
}
