<?php
namespace Sinergi\Project\Tests;

use PHPUnit_Framework_TestCase;
use Sinergi\Project\AutoloaderSetup;
use Sinergi\Project\Project\ProjectMapper;

class AutoloaderSetupTest extends PHPUnit_Framework_TestCase
{
    public function getProject()
    {
        return (new ProjectMapper())->map(__DIR__ . "/_files/project.xml");
    }

    public function getEventDispatcherMock()
    {
        return new ComposerEventDispatcherMock();
    }

    public function testSetup()
    {
        (new AutoloaderSetup($this->getProject(), $this->getEventDispatcherMock()))->setup();
    }
}