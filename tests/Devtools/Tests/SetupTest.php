<?php
namespace Sinergi\Devtools\Tests;

use PHPUnit_Framework_TestCase;
use Sinergi\Devtools\Setup;

class SetupTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Setup::setProjectXmlFile(__DIR__ . "/_files/project.xml");
    }

    public function getEventMock()
    {
        return new ComposerEventMock();
    }

    public function testSetupAutoloader()
    {
        $this->assertTrue(Setup::setupAutoloader($this->getEventMock()));
    }

    public function testSetupPhpStorm()
    {
        $this->assertTrue(Setup::setupPhpStorm($this->getEventMock()));
    }
}
