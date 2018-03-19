<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Class Attribute
 *
 * @package Alaa\XmlFeedModel\Model
 */
final class Attribute
{
    /**
     * @var string
     */
    private $xmlAttribute;

    /**
     * @var string
     */
    private $magentoAttribute;

    /**
     * @var string|int|float
     */
    private $value;

    /**
     * Value constructor.
     *
     * @param string     $xmlAttribute
     * @param string     $magentoAttribute
     * @param string|int $value
     */
    public function __construct(string $xmlAttribute, string $magentoAttribute, $value)
    {
        $this->xmlAttribute = $xmlAttribute;
        $this->magentoAttribute = $magentoAttribute;
        $this->value = $value;
    }

    /**
     * @param string           $xmlAttribute
     * @param string           $magentoAttribute
     * @param String|int|float $value
     * @param callable|null    $fn
     * @return Attribute
     */
    static public function create(string $xmlAttribute, string $magentoAttribute, $value, callable $fn = null): self
    {
        if (null !== $fn && is_callable($fn)) {
            $value = $fn($value);
        }

        return new self($xmlAttribute, $magentoAttribute, $value);
    }

    /**
     * @return string|int|float
     */
    public function value()
    {
        return $this->value;
    }
}
