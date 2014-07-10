<?php
namespace Sinergi\Project;

use Composer\Script\Event;
use Sinergi\Project\Ide\PhpStormIde;

class Setup
{
    /**
     * @param Event $event
     * @return bool
     */
    public static function setupAutoloader(Event $event)
    {
        if ($event->isDevMode()) {
            (new AutoloaderSetup())->setup();
            return true;
        }
        return false;
    }

    /**
     * @param Event $event
     * @return bool
     */
    public static function setupPhpStorm(Event $event)
    {
        if ($event->isDevMode()) {
            (new IdeSetup(new PhpStormIde()))->setup();
            return true;
        }
        return false;
    }
}