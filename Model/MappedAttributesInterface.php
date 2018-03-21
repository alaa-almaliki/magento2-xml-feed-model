<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Interface MappedAttributesInterface
 *
 * @package Alaa\XmlFeedModel\Model
 */
interface MappedAttributesInterface
{
    /**
     * Attribute name shown as xml text node
     */
    const XML_ATTRIBUTE_NAME = 'custom_attribute';

    /**
     * Attribute name from Magento data
     */
    const MAGENTO_ATTRIBUTE_NAME = 'magento_attribute';

    /**
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getMappedAttributes(
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): array;

    /**
     * @param array $mappedAttributes
     * @return MappedAttributesInterface
     */
    public function setMappedAttributes(array $mappedAttributes): MappedAttributesInterface;

    /**
     * @param string $xmlAttribute
     * @param string $magentoAttribute
     * @return MappedAttributesInterface
     */
    public function mapAttribute(string $xmlAttribute, string $magentoAttribute): MappedAttributesInterface;

    /**
     * @return string
     */
    public function getMappedAttributesConfigPath(): string;

    /**
     * @param string $path
     * @return MappedAttributesInterface
     */
    public function setMappedAttributesConfigPath(string $path): MappedAttributesInterface;
}
