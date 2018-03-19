<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Class CallbackStorage
 *
 * @package Alaa\XmlFeedModel\Model
 */
class CallbackStorage
{
    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * CallbackStorage constructor.
     *
     * @param array $callbacks
     */
    public function __construct(array $callbacks = [])
    {
        $this->callbacks = $callbacks;
    }

    /**
     * @param array $callbacks
     * @return CallbackStorage
     */
    public function setCallbacks(array $callbacks): self
    {
        $this->callbacks = $callbacks;
        return $this;
    }

    /**
     * @return array
     */
    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    /**
     * @param string $key
     * @return callable|null
     * @throws \Exception
     */
    public function getCallback(string $key)
    {
        if (!\array_key_exists($key, $this->callbacks)) {
            return null;
        }

        return $this->callbacks[$key];
    }

    /**
     * @return bool
     */
    public function hasCallbacks(): bool
    {
        return \count($this->callbacks) > 0;
    }

    /**
     * @param string   $key
     * @param callable $fn
     * @return CallbackStorage
     * @throws \Exception
     */
    public function registerCallback(string $key, callable $fn): self
    {
        if (!\is_callable($fn)) {
            throw new \Exception(\sprintf('Parameter 1 expected to be callable, %s given', \gettype($fn)));
        }

        $this->callbacks[$key] = $fn;
        return $this;
    }

    /**
     * @param string $key
     * @return CallbackStorage
     */
    public function unregisterCallback(string $key): self
    {
        if (!\array_key_exists($key, $this->callbacks)) {
            throw new \InvalidArgumentException(sprintf('Array key %s is not exists'));
        }

        unset($this->callbacks[$key]);
        return $this;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->callbacks = [];
    }
}
