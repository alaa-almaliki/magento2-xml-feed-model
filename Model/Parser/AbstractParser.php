<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model\Parser;

/**
 * Class AbstractParser
 *
 * @package Alaa\XmlFeedModel\Model\File
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractParser
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * AbstractParser constructor.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }
}
