<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Model;

use Alaa\XmlFeedModel\Exception\SubjectException;
use Magento\Framework\DataObject;

/**
 * Class Subject
 *
 * @package Alaa\XmlFeedModel\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Subject extends DataObject
{
    /**
     * @var string
     */
    protected $nodeName;

    /**
     * @var string
     */
    protected $path;
    /**
     * @var array Attributes for each node
     *
     * Associative Array Example: [
     *                              'customer' => ['account_id' => '100', 'locale' => 'en_GB']
     *                           ]
     */
    protected $attributes = [];

    /**
     * @var Subject[]|array
     */
    protected $children = [];

    /**
     * @var Subject|null
     */
    protected $parent;

    /**
     * Subject constructor.
     *
     * @param string $nodeName
     * @param array  $data
     */
    public function __construct(string $nodeName = null, array $data = [])
    {
        parent::__construct($data);
        $this->nodeName = $nodeName;
    }

    /**
     * @param string     $nodeName
     * @param string     $attributeName
     * @param string|int $value
     * @return Subject
     */
    public function addAttribute(string $nodeName, string $attributeName, $value): self
    {
        $attributes = [];
        if (\array_key_exists($nodeName, $this->attributes)) {
            $attributes = $this->attributes[$nodeName];
        }

        $attributes[$attributeName] = $value;
        $this->attributes[$nodeName] = $attributes;
        return $this;
    }

    /**
     * @param string $nodeName
     * @return array
     */
    public function getAttributes(string $nodeName)
    {
        if (!\array_key_exists($nodeName, $this->attributes)) {
            return [];
        }

        return $this->attributes[$nodeName];
    }

    /**
     * @param string $name
     * @return Subject
     */
    public function setNodeName(string $name): self
    {
        $this->nodeName = $name;
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
     * @return string
     */
    public function getPath(): string
    {
        if (!!$this->path === false) {
            $this->path = $this->getNodeName();
            if ($this->hasParent()) {
                $this->path = $this->getParent()->getPath() . '.' . $this->getNodeName();
            }
        }

        return $this->path;
    }

    /**
     * @param Subject $parent
     * @return $this
     */
    public function setParent(Subject $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Subject|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    public function hasParent(): bool
    {
        return !!$this->getParent() !== false;
    }

    /**
     * @param Subject $child
     * @return Subject
     * @throws SubjectException
     */
    public function addChild(Subject $child): self
    {
        foreach ($this->children as $childSubject) {
            if ($childSubject->getNodeName() === $child->getNodeName()) {
                throw new SubjectException(
                    \sprintf(
                        'Child with name %s already exists on parent %s',
                        $child->getName(),
                        $this->getName()
                    )
                );
            }
        }

        $child->setParent($this);
        $this->children[] = $child;
        return $this;
    }

    /**
     * @param string $nodeName
     * @return Subject
     * @throws SubjectException
     */
    public function getChild(string $nodeName): self
    {
        foreach ($this->children as $child) {
            if ($child->getNodeName() === $nodeName) {
                return $child;
            }
        }

        throw new SubjectException(\sprintf('Subject with node name %s is not exits', $nodeName));
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return array|Subject[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
