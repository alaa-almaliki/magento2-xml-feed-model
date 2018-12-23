<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Subject;

use Alaa\XmlFeedModel\Model\Subject;

/**
 * Interface TransformerInterface
 *
 * @package Alaa\XmlFeedModel\Subject
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface TransformerInterface
{
    /**
     * @param Subject $subject
     * @return Subject
     */
    public function transform(Subject $subject): Subject;
}
