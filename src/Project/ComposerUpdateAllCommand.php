<?php
namespace Sinergi\Project;

class ComposerUpdateAllCommand
{
    const COMPOSER_FILE = 'composer.json';

    /**
     * @var string
     */
    protected $cwd;

    public function __construct()
    {
        $this->cwd = getcwd();
    }

    public function run()
    {
        foreach ($this->getComposerRepos() as $repo) {
            $this->runComposerUpdate($repo);
        }
    }

    /**
     * @param string $repo
     */
    protected function runComposerUpdate($repo)
    {
        if (chdir($repo)) {
            $this->checkVendors($repo);
            chdir($repo);
            echo '---------------------------------------------' . PHP_EOL;
            echo 'Running composer update on ' . basename($repo) . PHP_EOL;
            echo '---------------------------------------------' . PHP_EOL;
            passthru("composer update --no-interaction");
        }
    }

    /**
     * @param $repo
     */
    protected function checkVendors($repo)
    {
        if (is_dir($repo . DIRECTORY_SEPARATOR . "vendor")) {
            foreach (scandir($repo . DIRECTORY_SEPARATOR . "vendor") as $vendor) {
                if (
                    substr($vendor, 0, 1) !== '.' &&
                    is_dir($repo . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . $vendor)
                ) {
                    $vendor = $repo . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . $vendor;
                    foreach (scandir($vendor) as $dependency) {
                        if (substr($dependency, 0, 1) !== '.') {
                            $dependency = $vendor . DIRECTORY_SEPARATOR . $dependency;
                            if (is_dir($dependency) && file_exists($dependency . DIRECTORY_SEPARATOR . '.git')) {
                                $this->discardDependencyUncommitedChanges($dependency);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $dependency
     */
    protected function discardDependencyUncommitedChanges($dependency)
    {
        if ($this->hasDependencyUncommitedChanges($dependency)) {
            chdir($dependency);

            ob_start();
            passthru("git checkout -- .");
            $retval = ob_get_contents();
            ob_end_clean();
        }
    }

    /**
     * @param string $dependency
     * @return bool
     */
    protected function hasDependencyUncommitedChanges($dependency)
    {
        chdir($dependency);

        ob_start();
        passthru("git status");
        $retval = ob_get_contents();
        ob_end_clean();

        if (stripos($retval, 'working directory clean') === false) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    protected function getComposerRepos()
    {
        $retval = [];
        foreach (scandir($this->cwd) as $dir) {
            if (substr($dir, 0, 1) !== '.' && is_dir($this->cwd . DIRECTORY_SEPARATOR . $dir)) {
                $dir = $this->cwd . DIRECTORY_SEPARATOR . $dir;
                $file = $dir . DIRECTORY_SEPARATOR . self::COMPOSER_FILE;
                if (file_exists($file)) {
                    $retval[] = $dir;
                }
            }
        }
        return $retval;
    }
}

(new ComposeUpdateAll())->run();
