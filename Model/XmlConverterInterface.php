<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Interface XmlConverterInterface
 *
 * @package Alaa\XmlFeedModel\Model
 */
interface XmlConverterInterface
{
    /**
     * @param Subject $rootSubject
     * @return XmlConverterInterface
     */
    public function toXml(Subject $rootSubject): XmlConverterInterface;

    /**
     * @param string $namespace
     * @param string $uri
     * @return XmlConverterInterface
     */
    public function addNamespace(string $namespace, string $uri): XmlConverterInterface;

    /**
     * @return XmlConverterInterface
     */
    public function withProlog(): XmlConverterInterface;

    /**
     * @return \SimpleXMLElement
     */
    public function getXml(): \SimpleXMLElement;

    /**
     * @param string $encoding
     * @return string
     */
    public function getProlog(string $encoding = "UTF-8"): string;

    /**
     * @param string $filename
     * @return bool
     */
    public function save(string $filename): bool;
}
