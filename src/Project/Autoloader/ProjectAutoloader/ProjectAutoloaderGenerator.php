<?php
namespace Sinergi\Project\Autoloader\ProjectAutoloader;

use Sinergi\Project\Project\Project;
use Sinergi\Project\Project\Source\SourceCollection;

class ProjectAutoloaderGenerator
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
     * @return array
     */
    public function generateAutoloader()
    {
        $autoloaders = $this->generateAutoloaders($this->project->getSources());
        $autoloaders['main'] = $this->generateMainAutoloader($autoloaders);
        return $autoloaders;
    }

    private function generateMainAutoloader($autoloaders)
    {
        $autoloaderTemplate = file_get_contents(__DIR__ . "/templates/autoload.txt");
        $itemTemplate = file_get_contents(__DIR__ . "/templates/autoload_item.txt");

        $autoloaderString = '';
        foreach ($autoloaders as $type => $autoloader) {
            $filename = ProjectAutoloaderFileMapper::getFilename($type);
            $autoloaderString .= str_replace('%file', $filename, $itemTemplate);
        }

        $autoloader = str_replace('%array', $autoloaderString, $autoloaderTemplate);

        return $autoloader;
    }

    /**
     * @param SourceCollection $sources
     * @return array
     */
    private function generateAutoloaders(SourceCollection $sources)
    {
        $autoloaders = [];
        foreach ($sources as $source) {
            $composerAutoloadConfig = $this->loadComposerAutoloadConfig(
                $this->project->getDir() . DIRECTORY_SEPARATOR . $source->getPath() .
                DIRECTORY_SEPARATOR . 'composer.json'
            );
            if (is_array($composerAutoloadConfig)) {
                foreach ($composerAutoloadConfig as $type => $autoloader) {
                    if ($type === 'psr-4') {
                        if (is_array($autoloader)) {
                            foreach ($autoloader as &$paths) {
                                if (!is_array($paths)) {
                                    $paths = [$paths];
                                }
                                $sharedPaths = [];
                                foreach ($paths as &$path) {
                                    $path = DIRECTORY_SEPARATOR .
                                        trim($source->getPath(), '\\/' . DIRECTORY_SEPARATOR) .
                                        DIRECTORY_SEPARATOR . $path;

                                    $dirname = basename($source->getPath());
                                    $sharedPaths[] = '/../shared' .
                                        DIRECTORY_SEPARATOR . $dirname .
                                        DIRECTORY_SEPARATOR . trim($path, '\\/' . DIRECTORY_SEPARATOR);
                                }
                                $paths = array_merge($paths, $sharedPaths);
                            }
                        } else {
                            $autoloader = [];
                        }
                        if (isset($autoloaders['psr-4'])) {
                            $autoloaders['psr-4'] = array_merge($autoloaders['psr-4'], $autoloader);
                        } else {
                            $autoloaders['psr-4'] = $autoloader;
                        }
                    }
                }
            }
        }
        $retval = [];
        foreach ($autoloaders as $type => $autoloader) {
            if ($type === 'psr-4') {
                $retval['psr-4'] = $this->generatePsr4Autoloaders($autoloader);
            }
        }
        return $retval;
    }

    /**
     * @param array $autoloaders
     * @return string
     */
    private function generatePsr4Autoloaders(array $autoloaders)
    {
        $autoloaderTemplate = file_get_contents(__DIR__ . "/templates/autoload_psr4.txt");
        $itemTemplate = file_get_contents(__DIR__ . "/templates/autoload_psr4_item.txt");

        $autoloaderString = '';
        foreach ($autoloaders as $namespace => $paths) {
            if (!is_array($paths)) {
                $paths = [$paths];
            }
            $namespace = str_replace(['\\\\', '\\'], ['\\', '\\\\'], $namespace);
            $pathsString = '';
            foreach ($paths as $path) {
                $path = DIRECTORY_SEPARATOR . trim($path, '/' . DIRECTORY_SEPARATOR);
                $pathsString .= "\$basedir . '{$path}', ";
            }
            $pathsString = substr($pathsString, 0, -2);
            $autoloaderString .= str_replace(['%namespace', '%paths'], [$namespace, $pathsString], $itemTemplate);
        }

        $autoloader = str_replace('%array', $autoloaderString, $autoloaderTemplate);

        return $autoloader;
    }

    /**
     * @param string $composerAutoloader
     * @param string $projectAutoloaderDir
     * @return string
     * @deprecated
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
     * @param string $path
     * @return array|null
     */
    private function loadComposerAutoloadConfig($path)
    {
        if (file_exists($path)) {
            $config = json_decode(file_get_contents($path), true);
            $config['autoload'] = !is_array($config['autoload']) ? [] : $config['autoload'];
            $config['autoload-dev'] = !is_array($config['autoload-dev']) ? [] : $config['autoload-dev'];
            foreach ($config['autoload-dev'] as $type => $autoloader) {
                if (isset($config['autoload'][$type])) {
                    $config['autoload'][$type] = array_merge($config['autoload'][$type], $autoloader);
                } else {
                    $config['autoload'][$type] = $autoloader;
                }
            }
            return $config['autoload'];
        }
        return null;
    }
}