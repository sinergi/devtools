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
     * @param string $projectAutoloaderDir
     * @return array
     */
    public function generateAutoloader($composerAutoloader, $projectAutoloaderDir)
    {
        $projectAutoloaderTemplate = file_get_contents(__DIR__ . "/templates/project_autoloader.txt");
        $projectAutoloaderDir = $this->getProjectDirPathDiff($composerAutoloader, $projectAutoloaderDir);

        $projectAutoloader = str_replace(
            '%file',
            $projectAutoloaderDir . DIRECTORY_SEPARATOR . ProjectAutoloaderFileMapper::getFilename('main'),
            $projectAutoloaderTemplate
        );

        $autoloaderContent = $this->getComposerAutoloaderContent($composerAutoloader);
        return preg_replace('/require_once/', $projectAutoloader . 'require_once', $autoloaderContent, 1);
    }

    /**
     * @param string $composerAutoloader
     * @param string $projectAutoloaderDir
     * @return string
     */
    private function getProjectDirPathDiff($composerAutoloader, $projectAutoloaderDir)
    {
        $composerAutoloaderDirs = explode(DIRECTORY_SEPARATOR, $composerAutoloader);
        $projectAutoloaderDirs = explode(DIRECTORY_SEPARATOR, $projectAutoloaderDir);
        $key = 0;
        foreach ($composerAutoloaderDirs as $key => $value) {
            if ($value !== $projectAutoloaderDirs[$key]) {
                break;
            }
        }
        $projectAutoloaderDirs = array_slice($projectAutoloaderDirs, $key, 1);
        return implode(DIRECTORY_SEPARATOR, $projectAutoloaderDirs);
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