<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Class XmlConverter
 *
 * @package Alaa\XmlFeedModel\Model
 */
class XmlConverter implements XmlConverterInterface
{
    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * @var string
     */
    protected $xmlString;

    /**
     * @var bool
     */
    protected $prolog = false;

    /**
     * @var string[]
     */
    protected $namespaces;

    /**
     * @param array       $data
     * @param null|string $dataKey
     * @return string
     */
    protected function toXmlString(array $data, $dataKey = null): string
    {
        $xml = '';
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                if (\is_numeric($key) && \is_array(current($value))) {
                    foreach ($value as $k => $v) {
                        $xml .= $this->toXmlString($v, $k);
                    }
                } else {
                    $xml .= $this->toXmlString($value, $key);
                }
            } else {
                $value = \str_replace(
                    ['&', '"', "'", '<', '>'],
                    ['&amp;', '&quot;', '&apos;', '&lt;', '&gt;'],
                    $value
                );
                $xml .= "<{$key}>{$value}</{$key}>\n";
            }
        }
        if ($dataKey) {
            $xml = "<{$dataKey}>\n{$xml}</{$dataKey}>\n";
        }
        return $xml;
    }

    /**
     * @param Subject $rootSubject
     * @return XmlConverterInterface
     */
    public function toXml(Subject $rootSubject): XmlConverterInterface
    {
        $this->xmlString = $this->toXmlString($rootSubject->getData(), $rootSubject->getNodeName());
        $this->xml = \simplexml_load_string($this->xmlString);
        return $this;
    }

    /**
     * @param string $namespace
     * @param string $uri
     * @return XmlConverterInterface
     */
    public function addNamespace(string $namespace, string $uri): XmlConverterInterface
    {
        $this->namespaces[$namespace] = $uri;
        return $this;
    }

    /**
     * @return XmlConverter
     */
    protected function addNamespaces(): self
    {
        foreach ($this->namespaces as $namespace => $uri) {
            $this->xml->addAttribute($namespace, $uri);
        }

        return $this;
    }

    /**
     * @return XmlConverterInterface
     */
    public function withProlog(): XmlConverterInterface
    {
        $this->prolog = true;
        return $this;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml(): \SimpleXMLElement
    {
        if ($this->withProlog()) {
            $xmlString = $this->getProlog() . PHP_EOL . $this->xmlString;
            $this->xmlString = $xmlString;
        }

        $this->xml = \simplexml_load_string($this->xmlString);
        $this->addNamespaces();
        return $this->xml;
    }

    /**
     * @param string $encoding
     * @return string
     */
    public function getProlog(string $encoding = "UTF-8"): string
    {
        return \sprintf('<?xml version="1.0" encoding="%s"?>', $encoding);
    }

    /**
     * @param string $filename
     * @return bool
     * @throws \Exception
     */
    public function save(string $filename): bool
    {
        $filePath = \dirname($filename);

        if (!\file_exists($filePath)) {
            $success = @\mkdir($filePath, 0777, true);
            if (!$success) {
                throw new \Exception(\sprintf('Can not create directory: %s', $filePath));
            }
        }

        if (\file_exists($filename) && \is_file($filename)) {
            if (!\is_writeable($filename)) {
                throw new \Exception(\sprintf('The file %s is not writable', $filename));
            }
        }

        return $this->getXml()->saveXML($filename);
    }
}
