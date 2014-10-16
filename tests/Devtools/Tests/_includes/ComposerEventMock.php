<?php
namespace Sinergi\Devtools\Tests;

use Composer\Script\Event;

class ComposerEventMock extends Event
{
    public function __construct()
    {
    }

    public function isDevMode()
    {
        return true;
    }
}
