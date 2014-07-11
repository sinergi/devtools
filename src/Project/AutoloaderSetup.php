<?php
namespace Sinergi\Project;

use Sinergi\Project\Autoloader\AutoloaderBuilder;
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

    /**
     * @return bool
     */
    public function setup()
    {
        $autoloaderGenerator = new AutoloaderBuilder($this->project);
        $autoloaderGenerator->createAutoloader(
            $this->getProjectAutoloaderDir(),
            $this->getComposerAutoloader()
        );
        return true;
    }

    /**
     * @return string
     */
    private function getComposerAutoloader()
    {
        return $this->project->getDir() . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
    }

    /**
     * @return string
     */
    private function getProjectAutoloaderDir()
    {
        return $this->project->getDir() . DIRECTORY_SEPARATOR . 'vendor/composer/project';
    }
}