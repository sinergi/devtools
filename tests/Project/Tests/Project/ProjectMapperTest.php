<?php
namespace Sinergi\Project\Tests\Project;

use PHPUnit_Framework_TestCase;
use Sinergi\Project\Project\ProjectMapper;

class ProjectMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Sinergi\Project\Exception\FileNotFoundException
     */
    public function testMapFileNotFound()
    {
        $projectMapper = new ProjectMapper();
        $projectMapper->map('');
    }

    public function testMap()
    {
        $projectMapper = new ProjectMapper();
        $project = $projectMapper->map(__DIR__ . "/../_files/project.xml");
        $this->assertInstanceOf('\\Sinergi\\Project\\Project\\Project', $project);
    }

    public function testMapSources()
    {
        $projectMapper = new ProjectMapper();
        $project = $projectMapper->map(__DIR__ . "/../_files/project.xml");
        $this->assertInstanceOf('\\Sinergi\\Project\\Project\\Source\\SourceCollection', $project->getSources());
        $this->assertCount(1, $project->getSources());
    }

    public function testMapSource()
    {
        $projectMapper = new ProjectMapper();
        $project = $projectMapper->map(__DIR__ . "/../_files/project.xml");
        $this->assertInstanceOf('\\Sinergi\\Project\\Project\\Source\\Source', $project->getSources()[0]);
        $this->assertEquals('directory_test', $project->getSources()[0]->getPath());
    }
}