<?php
namespace Sinergi\Project\Autoloader\ComposerAutoloader;

use Sinergi\Project\Autoloader\ProjectAutoloader\ProjectAutoloaderFileMapper;
use Sinergi\Project\Project\Project;

class ComposerAutoloaderGenerator
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
     * @param string $composerAutoloader
     * @return array
     */
    public function generateAutoloader($composerAutoloader)
    {
        $projectAutoloaderTemplate = file_get_contents(__DIR__ . "/templates/project_autoloader.txt");

        $projectAutoloader = str_replace(
            '%file',
            'composer/project/' . ProjectAutoloaderFileMapper::getFilename('main'),
            $projectAutoloaderTemplate
        );

        $autoloaderContent = $this->getComposerAutoloaderContent($composerAutoloader);
        return preg_replace('/return (.*)/', '$composer = $1' . $projectAutoloader, $autoloaderContent, 1);
    }

    /**
     * @param string $composerAutoloader
     * @return string
     */
    private function getComposerAutoloaderContent($composerAutoloader)
    {
        if (is_file($composerAutoloader)) {
            return file_get_contents($composerAutoloader);
        }
        return null;
    }
}