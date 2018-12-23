<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Alaa\XmlFeedModel\Exception\FileNotExistsException;
use Alaa\XmlFeedModel\Exception\SubjectException;
use Alaa\XmlFeedModel\Model\Validator\FileExistsFactory;

/**
 * Class MappedSubjectBuilder
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class MappedSubjectBuilder
{
    /**
     * @var SubjectMapperFactory
     */
    protected $subjectMapperFactory;

    /**
     * @var FileExistsFactory
     */
    protected $fileExistsFactory;

    /**
     * MappedSubjectBuilder constructor.
     *
     * @param SubjectMapperFactory $subjectMapperFactory
     * @param FileExistsFactory    $fileExistsFactory
     */
    public function __construct(
        SubjectMapperFactory $subjectMapperFactory,
        FileExistsFactory $fileExistsFactory
    ) {
        $this->subjectMapperFactory = $subjectMapperFactory;
        $this->fileExistsFactory = $fileExistsFactory;
    }

    /**
     * @param string  $filename
     * @param Subject $subject
     * @return Subject
     * @throws FileNotExistsException
     * @throws SubjectException
     */
    public function build(string $filename, Subject $subject): Subject
    {
        $this->validate($filename);
        $mapper = $this->subjectMapperFactory->create(['filename' => $filename]);
        $mappedSubject = $mapper->getMappedSubject($subject);
        $this->map($mapper, $mappedSubject, $subject);
        return $mappedSubject;
    }

    /**
     * @param \Alaa\XmlFeedModel\Model\SubjectMapper $mapper
     * @param Subject                                $mappedSubject
     * @param Subject                                $subject
     * @throws SubjectException
     */
    protected function map(SubjectMapper $mapper, Subject $mappedSubject, Subject $subject)
    {
        if ($subject->hasChildren()) {
            foreach ($subject->getChildren() as $child) {
                $mappedChild = $mapper->getMappedSubject($child);
                $mappedSubject->addChild($mappedChild);
                $this->map($mapper, $mappedChild, $child);
            }
        }
    }

    /**
     * @param string $filename
     * @throws FileNotExistsException
     */
    private function validate(string $filename)
    {
        $fileExists = $this->fileExistsFactory->create(['filename' => $filename]);
        if (!$fileExists->isValid()) {
            throw new FileNotExistsException(\sprintf('File %s is not exist', $filename));
        }
    }
}
