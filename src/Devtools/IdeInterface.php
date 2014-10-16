<?php
namespace Sinergi\Devtools;

interface IdeInterface
{
    function setupSources(array $sources);
    function setupPhpUnit();
    function setupComposer();
    function setupCodeSniffer();
    function setupMessDetector();
}