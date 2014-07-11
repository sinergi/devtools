<?php
namespace Sinergi\Project\Tests;

use PHPUnit_Framework_TestCase;
use Sinergi\Project\Autoloader\AutoloaderBuilder;
use Sinergi\Project\Project\ProjectMapper;

class AutoloaderBuilderTest extends PHPUnit_Framework_TestCase
{
    private $projectAutoloader;
    private $composerAutoloader;

    public function setUp()
    {
        $this->projectAutoloader = tempnam(sys_get_temp_dir(), 'SIN');
        unlink($this->projectAutoloader);
        mkdir($this->projectAutoloader);
        $this->composerAutoloader = tempnam(sys_get_temp_dir(), 'SIN');
        copy(__DIR__ . "/../_files/autoload.php", $this->composerAutoloader);
    }

    public function tearDown()
    {
        foreach (scandir($this->projectAutoloader) as $file) {
            if ($file !== '.' && $file !== '..' && is_file($this->projectAutoloader . DIRECTORY_SEPARATOR . $file)) {
                unlink($this->projectAutoloader . DIRECTORY_SEPARATOR . $file);
            }
        }
        rmdir($this->projectAutoloader);
        unlink($this->composerAutoloader);
    }

    public function getProject()
    {
        return (new ProjectMapper())->map(__DIR__ . "/../_files/project.xml");
    }

    public function testProjectAutoloaderBuilder()
    {
        $autoloaderGenerator = new AutoloaderBuilder($this->getProject());
        $autoloaderGenerator->createAutoloader(
            $this->projectAutoloader,
            $this->composerAutoloader
        );

        $this->assertFileExists($this->projectAutoloader . DIRECTORY_SEPARATOR . 'autoload.php');
        $this->assertFileExists($this->projectAutoloader . DIRECTORY_SEPARATOR . 'autoload_psr4.php');

        $this->assertContains(
            '<?php',
            file_get_contents($this->projectAutoloader . DIRECTORY_SEPARATOR . 'autoload.php')
        );

        $this->assertContains(
            '<?php',
            file_get_contents($this->projectAutoloader . DIRECTORY_SEPARATOR . 'autoload_psr4.php')
        );
    }

    public function testComposerAutoloaderBuilder()
    {
        $autoloaderGenerator = new AutoloaderBuilder($this->getProject());
        $autoloaderGenerator->createAutoloader(
            $this->projectAutoloader,
            $this->composerAutoloader
        );

        $this->assertFileExists($this->composerAutoloader);

        $dir = basename($this->projectAutoloader);
        $this->assertContains(
            "require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '{$dir}/autoload.php';",
            file_get_contents($this->composerAutoloader)
        );
    }
}