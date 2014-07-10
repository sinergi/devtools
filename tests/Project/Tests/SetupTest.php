<?php
namespace Sinergi\Project\Tests;

use PHPUnit_Framework_TestCase;
use Sinergi\Project\Setup;

class SetupTest extends PHPUnit_Framework_TestCase
{
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