<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model\Validator;

/**
 * Class FileExistsTest
 *
 * @package Alaa\XmlFeedModel\Model\Validator
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileExists
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * FileExistsTest constructor.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return \file_exists($this->filename) && \is_file($this->filename);
    }
}
