<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model\Parser;

/**
 * Interface ParserInterface
 *
 * @package Alaa\XmlFeedModel\Model\File
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ParserInterface
{
    /**
     * @return array
     */
    public function parse(): array;
}
