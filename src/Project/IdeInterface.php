<?php
namespace Sinergi\Project;

interface IdeInterface
{
    function setupSources(array $sources);
    function setupPhpUnit();
    function setupComposer();
    function setupCodeSniffer();
    function setupMessDetector();
}