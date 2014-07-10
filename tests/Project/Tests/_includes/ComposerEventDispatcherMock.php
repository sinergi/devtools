<?php
namespace Sinergi\Project\Tests;

use Composer\EventDispatcher\EventDispatcher;

class ComposerEventDispatcherMock extends EventDispatcher
{
    public function __construct()
    {
        return;
    }
}