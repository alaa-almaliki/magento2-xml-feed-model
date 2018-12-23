<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Subject;

use Alaa\XmlFeedModel\Model\Subject;

/**
 * Class Transformer
 *
 * @package Alaa\XmlFeedModel\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Transformer implements TransformerInterface
{
    /**
     * @var array
     */
    protected $mappedKeys;

    /**
     * Transformer constructor.
     *
     * @param array $mappedKeys
     */
    public function __construct(array $mappedKeys)
    {
        $this->mappedKeys = $mappedKeys;
    }

    /**
     * @param Subject $subject
     * @return Subject
     */
    public function transform(Subject $subject): Subject
    {
        $newMappedSubject = new Subject($subject->getNodeName());
        $this->transformAttributes($subject->getNodeName(), $subject, $newMappedSubject);

        foreach ($this->mappedKeys as $originalKey => $mappedKey) {
            if ($subject->hasData($originalKey)) {
                $newMappedSubject->setData($mappedKey, $subject->getData($originalKey));
                $this->transformAttributes($originalKey, $subject, $newMappedSubject);
            }
        }

        return $newMappedSubject;
    }

    /**
     * @param string  $nodeName
     * @param Subject $original
     * @param Subject $transformed
     */
    protected function transformAttributes(string $nodeName, Subject $original, Subject $transformed)
    {
        $attributes = $original->getAttributes($nodeName);
        if (!empty($attributes)) {
            foreach ($attributes as $name => $value) {
                $transformed->addAttribute($transformed->getNodeName(), $name, $value);
            }
        }
    }
}
