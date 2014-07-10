<?php
namespace Sinergi\Project\Project;

use SimpleXMLElement;
use Sinergi\Project\Exception\FileNotFoundException;
use Sinergi\Project\Project\Source\Source;
use Sinergi\Project\Project\Source\SourceCollection;

class ProjectMapper
{
    const PROJECT_XML_FILENAME = 'project.xml';

    /**
     * @param string $xmlFile
     * @return Project
     */
    public function map($xmlFile)
    {
        $content = $this->loadXmlFile($xmlFile);

        $project = new Project(realpath(dirname($xmlFile)));
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
                $source = $this->mapSource($source);
                if ($source instanceof Source) {
                    $sourceCollection->addSource($source);
                }
            }
        }
        return $sourceCollection;
    }

    /**
     * @param string $path
     * @return Source
     */
    private function mapSource($path)
    {
        $source = new Source();
        $source->setPath($path);
        return $source;
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