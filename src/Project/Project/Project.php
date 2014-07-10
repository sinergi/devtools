<?php
namespace Sinergi\Project\Project;

use Sinergi\Project\Project\Source\SourceCollection;

class Project
{
    /**
     * @var SourceCollection
     */
    private $sources;

    public function __construct()
    {
        $this->sources = new SourceCollection();
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