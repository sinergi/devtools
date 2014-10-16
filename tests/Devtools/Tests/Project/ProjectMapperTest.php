<?php
namespace Sinergi\Devtools\Tests\Project;

use PHPUnit_Framework_TestCase;
use Sinergi\Devtools\Project\Project;
use Sinergi\Devtools\Project\ProjectMapper;
use Sinergi\Devtools\Project\Source\Source;
use Sinergi\Devtools\Project\Source\SourceCollection;

class ProjectMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Sinergi\Devtools\Exception\FileNotFoundException
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
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testMapSources()
    {
        $projectMapper = new ProjectMapper();
        $project = $projectMapper->map(__DIR__ . "/../_files/project.xml");
        $this->assertInstanceOf(SourceCollection::class, $project->getSources());
        $this->assertCount(1, $project->getSources());
    }

    public function testMapSource()
    {
        $projectMapper = new ProjectMapper();
        $project = $projectMapper->map(__DIR__ . "/../_files/project.xml");
        $this->assertInstanceOf(Source::class, $project->getSources()[0]);
        $this->assertEquals('directory_test', $project->getSources()[0]->getPath());
    }
}
