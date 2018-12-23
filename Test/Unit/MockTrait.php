<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Test\Unit;

use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Trait MockTrait
 *
 * @package Alaa\XmlFeedModel\Test\Unit
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
trait MockTrait
{
    /**
     * @param string     $class
     * @param array|null $methods
     * @param array|null $constructorArgs
     * @return MockObject
     * @SuppressWarnings(PHPMD)
     */
    protected function getMock(string $class, array $methods = null, array $constructorArgs = null)
    {
        $builder = $this->getMockBuilder($class);

        if (null !== $constructorArgs) {
            $builder->setConstructorArgs($constructorArgs);
        } else {
            $builder->disableOriginalConstructor();
        }

        $builder->setMethods($methods);
        return $builder->getMock();
    }
}
