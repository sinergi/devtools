<?php
namespace Sinergi\Project\Project\Source;

use Countable;
use IteratorAggregate;
use ArrayAccess;
use JsonSerializable;
use ArrayIterator;

class SourceCollection implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    /**
     * @var array|Source[]
     */
    private $items = [];

    /**
     * @param Source $items
     */
    public function addSource(Source $items)
    {
        $this->items[] = $items;
    }

    /**
     * @return array|Source[]
     */
    public function getDirectories()
    {
        return $this->items;
    }

    /**
     * @param array|Source[] $directories
     * @return $this
     */
    public function setDirectories($directories)
    {
        $this->items = $directories;
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->items;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param string $offset
     * @return Source
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}