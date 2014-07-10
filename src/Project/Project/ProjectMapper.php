<?php
namespace Sinergi\Project\Project;

use SimpleXMLElement;
use Sinergi\Project\Exception\FileNotFoundException;
use Sinergi\Project\Project\Source\Directory\Directory;
use Sinergi\Project\Project\Source\SourceCollection;

class ProjectMapper
{
    /**
     * @param string $xmlFile
     * @return Project
     */
    public function map($xmlFile)
    {
        $content = $this->loadXmlFile($xmlFile);

        $project = new Project();
        $project->setSources($this->mapSources(isset($content['sources']) ? $content['sources'] : []));

        return $project;
    }

    /**
     * @param array $sources
     * @return SourceCollection
     */
    private function mapSources(array $sources)
    {
        $sourceCollection = new SourceCollection();
        foreach ($sources as $source) {
            if (!empty($source)) {
                $directory = $this->mapDirectory($source);
                if ($directory instanceof Directory) {
                    $sourceCollection->addDirectory($directory);
                }
            }
        }
        return $sourceCollection;
    }

    /**
     * @param string $path
     * @return Directory
     */
    private function mapDirectory($path)
    {
        $directory = new Directory();
        $directory->setPath($path);
        return $directory;
    }

    /**
     * @param string $file
     * @return array
     * @throws FileNotFoundException
     */
    private function loadXmlFile($file)
    {
        if (!is_file($file)) {
            throw new FileNotFoundException("File {$file} does not exists");
        }
        return json_decode(json_encode(new SimpleXMLElement(file_get_contents($file))), true);
    }
}