<?php
namespace Sinergi\Project\Autoloader;

use Sinergi\Project\Autoloader\ProjectAutoloader\ProjectAutoloaderFileMapper;
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
    private $projectAutoloaderDir;

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
     * @param string $projectAutoloaderDir
     * @param string $composerAutoloaderFile
     */
    public function createAutoloader($projectAutoloaderDir, $composerAutoloaderFile)
    {
        $this->projectAutoloaderDir = $projectAutoloaderDir;
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
        $projectAutoloaders = $projectAutoloaderGenerator->generateAutoloader();
        (new ProjectAutoloaderFileMapper())->saveProjectAutoaderFiles($this->projectAutoloaderDir, $projectAutoloaders);
    }

    private function generateComposerAutoloader()
    {

    }
}