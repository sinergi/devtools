<?php
namespace Sinergi\Project\Dependency;

class DependencyController
{
    /**
     * @param DependencyEntity $dependency
     */
    public function deleteDependencyDirectory(DependencyEntity $dependency)
    {
        $name = $dependency->getName();
        $name = trim($name, '. /\\' . DIRECTORY_SEPARATOR . PHP_EOL);
        $name = str_replace('/../', '/', $name);
        if (strlen($name) > 0) {
            $dir = $dependency->getProject()->getDir() .
                DIRECTORY_SEPARATOR . 'vendor' .
                DIRECTORY_SEPARATOR . $name;
            if (is_dir($dir)) {
                // todo: backing up the bin directory does not ensure that all bin files are kept as
                // todo: the might be in any directory
                $binBackup = $this->createBinDirectoryBackup($dir);
                $this->deleteDirectoryRecursively($dir);
                if ($binBackup) {
                    $this->restoreBinDirectory($binBackup);
                }
            }
        }
    }

    /**
     * @param string $dir
     * @return array|null
     */
    private function createBinDirectoryBackup($dir)
    {
        $source = $dir . "/bin";
        if (is_dir($source)) {
            $dest = tempnam(sys_get_temp_dir(), 'BINBAK_');
            if (is_file($dest)) {
                unlink($dest);
                mkdir($dest, 0777, true);
            }
            $this->copyDirectoryRecursively($source, $dest);
            return [$source, $dest];
        }
        return null;
    }

    /**
     * @param array $parameters
     */
    private function restoreBinDirectory(array $parameters)
    {
        list($dest, $source) = $parameters;
        $this->copyDirectoryRecursively($source, $dest);
        $this->deleteDirectoryRecursively($source);
    }

    /**
     * @param string $dir
     */
    private function deleteDirectoryRecursively($dir)
    {
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if ($file !== "." && $file !== "..") {
                    if (is_dir("{$dir}/{$file}")) {
                        $this->deleteDirectoryRecursively("{$dir}/{$file}");
                    } else {
                        unlink("{$dir}/{$file}");
                    }
                }
            }
            rmdir($dir);
        }
    }

    /**
     * @param string $source
     * @param string $dest
     */
    private function copyDirectoryRecursively($source, $dest)
    {
        if (is_dir($source)) {
            if (!is_dir($dest)) {
                mkdir($dest, 0777, true);
            }
            foreach (scandir($source) as $file) {
                if ($file !== "." && $file !== "..") {
                    if (is_dir("{$source}/{$file}")) {
                        $this->copyDirectoryRecursively("{$source}/{$file}", "{$dest}/{$file}");
                    } else {
                        copy("{$source}/{$file}", "{$dest}/{$file}");
                    }
                }
            }
        }
    }
}