<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use SimpleXMLElement;

/**
 * Class SimpleXml
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SimpleXml extends SimpleXMLElement
{
    /**
     * @param SimpleXMLElement $child
     * @return SimpleXml
     */
    public function append(\SimpleXMLElement $child): self
    {
        $root = dom_import_simplexml($this);
        $element = dom_import_simplexml($child);
        $root->appendChild($root->ownerDocument->importNode($element, true));
        return $this;
    }
}
