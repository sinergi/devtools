<?php
namespace Sinergi\Project\Autoloader;

use Sinergi\Project\Autoloader\ProjectAutoloader\ProjectAutoloaderGenerator;
use Sinergi\Project\Project\Project;

class AutoloaderBuilder
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var string
     */
    private $projectAutoloaderFile;

    /**
     * @var string
     */
    private $composerAutoloaderFile;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @param string $projectAutoloaderFile
     * @param string $composerAutoloaderFile
     */
    public function create($projectAutoloaderFile, $composerAutoloaderFile)
    {
        $this->projectAutoloaderFile = $projectAutoloaderFile;
        $this->composerAutoloaderFile = $composerAutoloaderFile;

        $this->generateProjectAutoloader();
        $this->generateComposerAutoloader();
    }

    /**
     * @return string
     */
    private function getComposerAutoloader()
    {
        return file_get_contents($this->composerAutoloaderFile);
    }

    private function generateProjectAutoloader()
    {
        $projectAutoloaderGenerator = new ProjectAutoloaderGenerator($this->project);
        $projectAutoloaderGenerator->generate();

    }

    private function generateComposerAutoloader()
    {

    }
}