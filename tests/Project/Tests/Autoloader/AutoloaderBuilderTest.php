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
        $this->composerAutoloader = tempnam(sys_get_temp_dir(), 'SIN');
        copy(__DIR__ . "/../_files/autoload.php", $this->composerAutoloader);
    }

    public function getProject()
    {
        return (new ProjectMapper())->map(__DIR__ . "/../_files/project.xml");
    }

    public function testTrue()
    {
        $autoloaderGenerator = new AutoloaderBuilder($this->getProject());
        $autoloaderGenerator->create(
            $this->projectAutoloader,
            $this->composerAutoloader
        );
    }
}