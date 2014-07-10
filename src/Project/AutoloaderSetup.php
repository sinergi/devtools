<?php
namespace Sinergi\Project;

use Composer\Autoload\AutoloadGenerator;
use Composer\EventDispatcher\EventDispatcher;
use Sinergi\Project\Project\Project;

class AutoloaderSetup
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @param Project $project
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(Project $project, EventDispatcher $eventDispatcher)
    {
        $this->project = $project;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setup()
    {
        return;
    }
}