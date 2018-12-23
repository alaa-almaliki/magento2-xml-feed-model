<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Model\Validator;

use Alaa\XmlFeedModel\Model\Validator\FileExists;
use PHPUnit\Framework\TestCase;

/**
 * Class FileExistsTest
 *
 * @package Alaa\XmlFeedModel\Test\Model\Validator
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileExistsTest extends TestCase
{
    public function testIsValid()
    {
        $validator = new FileExists(__DIR__ . '/../../_files/array.php');
        $this->assertTrue($validator->isValid());
    }
}
