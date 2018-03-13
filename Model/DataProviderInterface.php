<?php

namespace Alaa\XmlFeedModel\Model;

/**
 * Interface DataProviderInterface
 * @package Alaa\XmlFeedModel\Model
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface DataProviderInterface
{
    /**
     * @return array
     */
    public function getSourceData();

    /**
     * @return string
     */
    public function getOutputFile();
}