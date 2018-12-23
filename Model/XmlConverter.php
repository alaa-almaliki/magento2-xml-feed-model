<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Class XmlConverter
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class XmlConverter
{
    /**
     * @param Subject $subject
     * @param string  $encoding
     * @return SimpleXml
     */
    public function convert(Subject $subject, string $encoding = 'UTF-8'): SimpleXml
    {
        $xml = new SimpleXml("{$this->getProlog($encoding)}<{$subject->getNodeName()}/>");
        $this->addAttributes($xml, $subject, $subject->getNodeName());

        foreach ($subject->getData() as $key => $value) {
            if (!is_scalar($value)) {
                continue;
            }
            $xml->addChild($key, $value);
            $this->addAttributes($xml, $subject, $key);
        }

        if ($subject->hasChildren()) {
            foreach ($subject->getChildren() as $child) {
                $xml->append($this->convert($child));
            }
        }

        return $xml;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param Subject           $subject
     * @param string            $nodeName
     */
    protected function addAttributes(\SimpleXMLElement $xml, Subject $subject, string $nodeName)
    {
        $attributes = $subject->getAttributes($nodeName);
        foreach ($attributes as $attributeName => $attributeValue) {
            $xml->addAttribute($attributeName, $attributeValue);
        }
    }

    /**
     * @param string $encoding
     * @return string
     */
    protected function getProlog(string $encoding): string
    {
        return '<?xml version="1.0" encoding="'. $encoding . '"?>';
    }
}
