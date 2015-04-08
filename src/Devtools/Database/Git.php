<?php

namespace Sinergi\Devtools\Database;

class Git
{
    /**
     * @param $cwd
     * @param GitRepositoryInterface $gitRepository
     */
    public static function cloneRepository($cwd, GitRepositoryInterface $gitRepository)
    {
        chdir($cwd);
        passthru("git clone -b {$gitRepository->getBranch()} {$gitRepository->getRepository()}");
    }
}
