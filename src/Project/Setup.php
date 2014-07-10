<?php
namespace Sinergi\Project;

use Composer\Script\Event;
use Sinergi\Project\Ide\PhpStormIde;
use Sinergi\Project\Project\ProjectMapper;
use Sinergi\Project\Project\Project;

class Setup
{
    /**
     * @var string
     */
    private static $projectXmlFile;

    /**
     * @var Project
     */
    private static $project;

    /**
     * @param Event $event
     * @return bool
     */
    public static function setupAutoloader(Event $event)
    {
        if ($event->isDevMode()) {
            (new AutoloaderSetup(self::getProject(), $event))->setup();
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
            (new IdeSetup(self::getProject(), new PhpStormIde()))->setup();
            return true;
        }
        return false;
    }

    /**
     * return string
     */
    private static function findProjectXmlFile()
    {
        return getcwd() . DIRECTORY_SEPARATOR . ProjectMapper::PROJECT_XML_FILENAME;
    }

    /**
     * @return string
     */
    public static function getProjectXmlFile()
    {
        if (null === self::$projectXmlFile) {
            self::$projectXmlFile = self::findProjectXmlFile();
        }
        return self::$projectXmlFile;
    }

    /**
     * @param string $projectXmlFile
     */
    public static function setProjectXmlFile($projectXmlFile)
    {
        self::$projectXmlFile = $projectXmlFile;
    }

    /**
     * @return Project
     */
    public static function getProject()
    {
        if (null === self::$project) {
            self::$project = ( new ProjectMapper())->map(self::getProjectXmlFile());
        }
        return self::$project;
    }

    /**
     * @param Project $project
     * @return $this
     */
    public static function setProject(Project $project)
    {
        self::$project = $project;
    }
}