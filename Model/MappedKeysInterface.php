<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Interface MappedKeysInterface
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface MappedKeysInterface
{
    /**
     * @return array
     */
    public function getMappedKeys(): array;
}
