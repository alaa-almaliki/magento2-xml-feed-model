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
     * @param array            $data
     * @param callable|null    $fn
     * @return Attribute
     */
    static public function create(string $xmlAttribute, string $magentoAttribute, array $data, callable $fn = null): self
    {
        $value = '';

        if (array_key_exists($magentoAttribute, $data)) {
            $value = $data[$magentoAttribute];
        }

        if (null !== $fn && is_callable($fn)) {
            $value = $fn($data);
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
