<?php
namespace Sinergi\Devtools;

use Sinergi\Devtools\Autoloader\AutoloaderBuilder;
use Sinergi\Devtools\Dependency\DependencyController;
use Sinergi\Devtools\Dependency\DependencyEntity;
use Sinergi\Devtools\Project\Project;

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
        $this->dependencySetup();
        return true;
    }

    private function dependencySetup()
    {
        $dependencyController = new DependencyController();
        foreach ($this->project->getSources() as $source) {
            $name = $this->loadComposerConfigName(
                $this->project->getDir() . DIRECTORY_SEPARATOR . $source->getPath() .
                DIRECTORY_SEPARATOR . 'composer.json'
            );
            $dependency = new DependencyEntity($this->project);
            $dependency->setName($name);
            $dependencyController->deleteDependencyDirectory($dependency);
        }
    }

    /**
     * @param string $path
     * @return string|null
     */
    private function loadComposerConfigName($path)
    {
        if (file_exists($path)) {
            $config = json_decode(file_get_contents($path), true);
            return isset($config['name']) ? $config['name'] : null;
        }
        return null;
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
