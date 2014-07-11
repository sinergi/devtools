<?php
namespace Sinergi\Project\Dependency;

class DependencyController
{
    /**
     * @param DependencyEntity $dependency
     */
    public function deleteDependencyDirectory(DependencyEntity $dependency)
    {
        $dir = $dependency->getProject()->getDir() .
            DIRECTORY_SEPARATOR . 'vendor' .
            DIRECTORY_SEPARATOR . $dependency->getName();
        if (is_dir($dir)) {
            $this->deleteDirectoryRecursively($dir);
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