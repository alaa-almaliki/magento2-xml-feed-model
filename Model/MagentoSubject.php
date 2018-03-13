<?php

namespace Alaa\XmlFeedModel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Xml\Data\CallbackStorage;
use Xml\Data\Subject;

/**
 * Class MagentoSubject
 * @package Alaa\XmlFeedModel\Model
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class MagentoSubject extends Subject
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Json
     */
    protected $json;

    /**
     * MagentoSubject constructor.
     * @param CallbackStorage $storage
     * @param ScopeConfigInterface $scopeConfig
     * @param Json $json
     * @param String|null $nodeName
     */
    public function __construct(
        CallbackStorage $storage,
        ScopeConfigInterface $scopeConfig,
        Json $json,
        $nodeName = null
    ) {
        parent::__construct($storage, $nodeName);
        $this->scopeConfig = $scopeConfig;
        $this->json = $json;
    }

    /**
     * @return array
     */
    public function getMappedAttributes()
    {
        if (!$this->getMappedAttributesPath()) {
            return [];
        }

        $attributes = $this->json->unserialize($this->scopeConfig->getValue($this->getMappedAttributesPath()));
        $mappedAttributes = [];
        foreach ($attributes as $attribute) {
            $mappedAttributes[$attribute['custom_attribute']] = $attribute['magento_attribute'];
        }
        return $mappedAttributes;
    }

    /**
     * @return string
     */
    abstract protected function getMappedAttributesPath();
}