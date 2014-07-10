<?php
namespace Sinergi\Project;

class IdeSetup
{
    /**
     * @var IdeInterface
     */
    private $ide;

    /**
     * @param IdeInterface $ide
     */
    public function __construct(IdeInterface $ide)
    {
        $this->ide = $ide;
    }

    public function setup()
    {

    }
}