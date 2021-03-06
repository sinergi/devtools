<?php
namespace Sinergi\Devtools\Autoloader\ProjectAutoloader;

class ProjectAutoloaderFileMapper
{
    /**
     * @var array
     */
    private static $filenames = [
        'main' => 'autoload.php',
        'psr-4' => 'autoload_psr4.php'
    ];

    /**
     * @param string $dir
     * @param array $autoloaders
     */
    public function saveProjectAutoaderFiles($dir, array $autoloaders)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        foreach ($autoloaders as $type => $content) {
            $filename = self::$filenames[$type];
            file_put_contents($dir . DIRECTORY_SEPARATOR . $filename, $content);
        }
    }

    /**
     * @param string $type
     * @return string
     */
    public static function getFilename($type)
    {
        return isset(self::$filenames[$type]) ? self::$filenames[$type] : null;
    }
}
