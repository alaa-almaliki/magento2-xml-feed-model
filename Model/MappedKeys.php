<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

/**
 * Class MappedKeys
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class MappedKeys implements MappedKeysInterface
{
    /**
     * @var string
     */
    protected $xmlPath;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * XmlPathValue constructor.
     *
     * @param string               $xmlPath
     * @param ScopeConfigInterface $scopeConfig
     * @param Json                 $serializer
     */
    public function __construct(
        string $xmlPath,
        ScopeConfigInterface $scopeConfig,
        Json $serializer
    ) {
        $this->xmlPath = $xmlPath;
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @param null $store
     * @return array
     */
    public function getMappedKeys($store = null): array
    {
        if (!!$this->xmlPath === false) {
            return [];
        }

        $value = (string) $this->scopeConfig
            ->getValue($this->xmlPath, ScopeInterface::SCOPE_STORE, $store);
        $mappedKeys = [];
        foreach ($this->serializer->unserialize($value) as $serializedValue) {
            $mappedKeys[$serializedValue['magento_attribute']] = $serializedValue['custom_attribute'];
        }

        return $mappedKeys;
    }
}
