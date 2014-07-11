<?php
namespace Sinergi\Project\Autoloader\ComposerAutoloader;

class ComposerAutoloaderFileMapper
{
    /**
     * @param string $file
     * @param array $autoloader
     */
    public function saveComposerAutoader($file, $autoloader)
    {
        file_put_contents($file, $autoloader);
    }
}
