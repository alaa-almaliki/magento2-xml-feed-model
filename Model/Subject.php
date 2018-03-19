<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

/**
 * Class Subject
 *
 * @package Alaa\XmlFeedModel\Model
 */
class Subject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var CallbackStorage
     */
    protected $callbackStorage;

    /**
     * @var MappedAttributesInterface
     */
    protected $mappedAttributes;

    /**
     * @var string
     */
    protected $nodeName;

    /**
     * @var string
     */
    protected $configPath;

    /**
     * @var array
     */
    protected $subjects = [];

    /**
     * Subject constructor.
     *
     * @param CallbackStorage                  $callbackStorage
     * @param MappedAttributesInterfaceFactory $mappedAttributesFactory
     * @param string                           $nodeName
     * @param string                           $configPath
     */
    public function __construct(
        CallbackStorage $callbackStorage,
        MappedAttributesInterfaceFactory $mappedAttributesFactory,
        string $nodeName = '',
        string $configPath = ''
    ) {
        $this->callbackStorage = $callbackStorage;
        $this->mappedAttributes = $mappedAttributesFactory->create();
        $this->nodeName = $nodeName;
        $this->setMappedAttributesConfigPath($configPath);
        $this->addCallbacks();
    }

    /**
     * @param string $mappedAttributesConfigPath
     * @return Subject
     */
    public function setMappedAttributesConfigPath(string $mappedAttributesConfigPath): self
    {
        $this->configPath = $mappedAttributesConfigPath;
        $this->mappedAttributes->setMappedAttributesConfigPath($this->configPath);
        return $this;
    }

    /**
     * @param array $mappedAttributes
     * @return Subject
     */
    public function setMappedAttributes(array $mappedAttributes): self
    {
        $this->mappedAttributes->setMappedAttributes($mappedAttributes);
        return $this;
    }

    /**
     * @return Subject
     */
    protected function addCallbacks(): self
    {
        return $this;
    }

    /**
     * @param string   $attributeCode
     * @param callable $fn
     * @return Subject
     */
    public function addCallback(string $attributeCode, callable $fn): self
    {
        $this->callbackStorage->registerCallback($attributeCode, $fn);
        return $this;
    }

    /**
     * @param string $magentoAttribute
     * @param string $xmlAttribute
     * @return callable|null
     *
     * @throws \Exception
     */
    public function getCallback(string $magentoAttribute, string $xmlAttribute = '')
    {
        $callback = $this->callbackStorage->getCallback($magentoAttribute);

        if (null === $callback) {
            $callback = $this->callbackStorage->getCallback($xmlAttribute);
        }

        return $callback;
    }

    /**
     * @return CallbackStorage
     */
    public function getCallbackStorage(): CallbackStorage
    {
        return $this->callbackStorage;
    }

    /**
     * @param array $data
     * @return Subject
     */
    public function setData(array $data): self
    {
        foreach ($this->mappedAttributes->getMappedAttributes() as $xmlAttribute => $magentoAttribute) {
            if (\array_key_exists($magentoAttribute, $data)) {
                $callback = $this->getCallback($magentoAttribute, $xmlAttribute);
                $value = Attribute::create($xmlAttribute, $magentoAttribute, $data[$magentoAttribute], $callback)
                    ->value();
                $this->data[$xmlAttribute] = $value;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if ($this->hasSubjects()) {
            $this->recursiveData($this->subjects);
        }

        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getData();
    }

    /**
     * @param Subject $subject
     * @param string  $nodeName
     * @return Subject
     * @throws \Exception
     */
    public function addSubject(Subject $subject, string $nodeName = ''): self
    {
        if ($nodeName) {
            $subject->setNodeName($nodeName);
        }

        if (!$subject->getNodeName()) {
            throw new \Exception('Subject must have a node name.');
        }

        $this->subjects[$subject->getNodeName()] = $subject;
        return $this;
    }

    /**
     * @param array  $subjects
     * @param string $nodeName
     * @return Subject
     */
    public function addSubjects(array $subjects, string $nodeName): self
    {
        $this->subjects[$nodeName] = $subjects;
        return $this;
    }

    /**
     * @return array
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @return bool
     */
    public function hasSubjects(): bool
    {
        return \count($this->subjects) > 0;
    }

    /**
     * @param string $nodeName
     * @return Subject
     */
    public function setNodeName(string $nodeName): self
    {
        $this->nodeName = $nodeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getNodeName(): string
    {
        return $this->nodeName;
    }

    /**
     * @param array       $subjects
     * @param null|string $nodeName
     */
    private function recursiveData(array $subjects, $nodeName = null)
    {
        foreach ($subjects as $n => $subject) {
            if (\is_array($subject)) {
                $this->recursiveData($subject, $n);
            } else {
                if (null !== $nodeName) {
                    $this->data[$nodeName][$n] = [$subject->getNodeName() => $subject->getData()];
                } else {
                    $this->data[$n] = $subject->getData();
                }
            }
        }
    }
}
