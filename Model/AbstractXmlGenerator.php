<?php

namespace Alaa\XmlFeedModel\Model;

use Xml\Data\Mapper;

/**
 * Class AbstractXmlGenerator
 * @package Alaa\XmlFeedModel\Model
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractXmlGenerator
{
    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * AbstractXmlGenerator constructor.
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * Generate xml file
     */
    public function generate()
    {
        $mapper = Mapper::convert($this->getRootSubject())
            ->toXml();

        if ($this->withOpenTag()) {
            $mapper->withOpenTag();
        }

        if (count($this->getNamespaces()) > 0) {
            foreach ($this->getNamespaces() as $attribute => $uri) {
                $mapper->addNamespace($attribute, $uri);
            }
        }

        $mapper->write($this->dataProvider->getOutputFile());
    }

    /**
     * @return DataProviderInterface
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    /**
     * @return bool
     */
    protected function withOpenTag()
    {
        return false;
    }

    /**
     * @return array
     */
    protected function getNamespaces()
    {
        return [];
    }

    /**
     * @return MagentoSubject
     */
    abstract protected function getRootSubject();
}