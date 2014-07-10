<?php
namespace Sinergi\Project;

use Composer\Script\Event;
use Sinergi\Project\Ide\PhpStormIde;

class Setup
{
    public static function setupAutoloader(Event $event)
    {
        if ($event->isDevMode()) {

        }
    }

    public static function setupPhpStorm(Event $event)
    {
        if ($event->isDevMode()) {
            (new IdeSetup(new PhpStormIde()))->setup();
        }
    }
}