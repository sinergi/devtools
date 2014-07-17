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
                $this->deleteDirectoryRecursively($dir);
            }
        }
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
}