<?php
namespace Sinergi\Project\Tests;

use PHPUnit_Framework_TestCase;
use Sinergi\Project\AutoloaderSetup;
use Sinergi\Project\Project\ProjectMapper;

class AutoloaderSetupTest extends PHPUnit_Framework_TestCase
{
    private $dir;

    public function setUp()
    {
        $this->dir = tempnam(sys_get_temp_dir(), 'SIN');
        unlink($this->dir);
        mkdir($this->dir);
        mkdir($this->dir . DIRECTORY_SEPARATOR . 'vendor');
        copy(__DIR__ . "/_files/autoload.php", $this->dir . DIRECTORY_SEPARATOR . 'vendor/autoload.php');
        copy(__DIR__ . "/_files/project.xml", $this->dir . DIRECTORY_SEPARATOR . 'project.xml');
    }

    public function getProject()
    {
        $project = (new ProjectMapper())->map(__DIR__ . "/_files/project.xml");
        $project->setDir($this->dir);
        return $project;
    }

    public function testSetup()
    {
        $this->assertTrue((new AutoloaderSetup($this->getProject()))->setup());
    }
}