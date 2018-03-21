<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class MappedAttributes
 *
 * @package Alaa\XmlFeedModel\Model
 */
class MappedAttributes implements MappedAttributesInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $mappedAttributes = [];

    /**
     * @var string
     */
    protected $configPath;

    /**
     * MappedAttributes constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Json                 $serializer
     */
    public function __construct(ScopeConfigInterface $scopeConfig, Json $serializer)
    {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @param string $scopeType
     * @param null   $scopeCode
     * @return array
     */
    public function getMappedAttributes(
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): array {
        if (!$this->getMappedAttributesConfigPath()) {
            $mappedAttributes = [];
        } else {
            $value = $this->scopeConfig->getValue($this->getMappedAttributesConfigPath(), $scopeType, $scopeCode);
            $mappedAttributes = $this->serializer->unserialize($value);
        }

        $this->mappedAttributes = \array_merge($this->normalize($mappedAttributes), $this->mappedAttributes);
        return $this->mappedAttributes;
    }

    /**
     * @param array $mappedAttributes
     * @return MappedAttributesInterface
     */
    public function setMappedAttributes(array $mappedAttributes): MappedAttributesInterface
    {
        $this->mappedAttributes = $mappedAttributes;
        return $this;
    }

    /**
     * @param string $xmlAttribute
     * @param string $magentoAttribute
     * @return MappedAttributesInterface
     * @throws \Exception
     */
    public function mapAttribute(string $xmlAttribute, string $magentoAttribute): MappedAttributesInterface
    {
        if (array_key_exists($xmlAttribute, $this->mappedAttributes)) {
            throw new \Exception(sprintf('Attribute %s is already exist', $xmlAttribute));
        }

        $this->mappedAttributes[$xmlAttribute] = $magentoAttribute;
        return $this;
    }

    /**
     * @return string
     */
    public function getMappedAttributesConfigPath(): string
    {
        return $this->configPath;
    }

    /**
     * @param string $path
     * @return MappedAttributesInterface
     */
    public function setMappedAttributesConfigPath(string $path): MappedAttributesInterface
    {
        $this->configPath = $path;
        return $this;
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function normalize(array $attributes): array
    {
        $normalized = [];
        foreach ($attributes as $attribute) {
            $normalized[$attribute[self::XML_ATTRIBUTE_NAME]] = $attribute[self::MAGENTO_ATTRIBUTE_NAME];
        }

        return $normalized;
    }
}
