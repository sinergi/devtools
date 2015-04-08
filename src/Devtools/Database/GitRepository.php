<?php

namespace Sinergi\Devtools\Database;

class GitRepository implements GitRepositoryInterface
{
    /**
     * @var string
     */
    private $repository;

    /**
     * @var string
     */
    private $branch;

    /**
     * @param string $repository
     * @param string $branch
     */
    public function __construct($repository, $branch)
    {
        $this->repository = $repository;
        $this->branch = $branch;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }
}
