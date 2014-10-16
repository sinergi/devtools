<?php
namespace Sinergi\Devtools\Project;

use Sinergi\Devtools\Project\Source\SourceCollection;

class Project
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var SourceCollection
     */
    private $sources;

    public function __construct($dir)
    {
        $this->dir = $dir;
        $this->sources = new SourceCollection();
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * @return SourceCollection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * @param SourceCollection $sources
     * @return $this
     */
    public function setSources(SourceCollection $sources)
    {
        $this->sources = $sources;
        return $this;
    }
}