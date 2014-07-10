<?php
namespace Sinergi\Project;

use Sinergi\Project\Project\Project;

class AutoloaderSetup
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function setup()
    {

    }
}