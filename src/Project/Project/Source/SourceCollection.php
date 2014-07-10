<?php
namespace Sinergi\Project\Project\Source;

use Countable;
use IteratorAggregate;
use ArrayAccess;
use JsonSerializable;
use ArrayIterator;
use Sinergi\Project\Project\Source\Directory\Directory;

class SourceCollection implements Countable, IteratorAggregate, ArrayAccess, JsonSerializable
{
    /**
     * @var array|Directory[]
     */
    private $directories = [];

    /**
     * @param Directory $directory
     */
    public function addDirectory(Directory $directory)
    {
        $this->directories[] = $directory;
    }

    /**
     * @return array|Directory[]
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @param array|Directory[] $directories
     * @return $this
     */
    public function setDirectories($directories)
    {
        $this->directories = $directories;
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->directories);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->directories);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->directories;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->directories[$offset]);
    }

    /**
     * @param string $offset
     * @return Directory
     */
    public function offsetGet($offset)
    {
        return $this->directories[$offset];
    }

    /**
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->directories[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->directories[$offset]);
    }
}