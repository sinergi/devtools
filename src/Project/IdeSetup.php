<?php
namespace Sinergi\Project;

use Sinergi\Project\Project\Project;

class IdeSetup
{
    /**
     * @var IdeInterface
     */
    private $ide;

    /**
     * @param Project $project
     * @param IdeInterface $ide
     */
    public function __construct(Project $project, IdeInterface $ide)
    {
        $this->ide = $ide;
    }

    public function setup()
    {

    }
}