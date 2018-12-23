<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model\Parser;

/**
 * Class PhpArrayParser
 *
 * @package Alaa\XmlFeedModel\Model\Parser
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class PhpArrayParser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     */
    public function parse(): array
    {
        return (array) $this->includeFile($this->filename);
    }

    /**
     * @param string $file
     * @return mixed
     */
    protected function includeFile(string $file)
    {
        return include $file;
    }
}
