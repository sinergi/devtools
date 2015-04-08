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
        passthru("git init");
        passthru("git remote add origin {$gitRepository->getRepository()}");
        passthru("git fetch");
        passthru("git checkout {$gitRepository->getBranch()}");
    }

    /**
     * @param $cwd
     * @param GitRepositoryInterface $gitRepository
     */
    public static function commit($cwd, GitRepositoryInterface $gitRepository)
    {
        chdir($cwd);
        passthru("git add .");
        passthru("git commit -m \"update\"");
    }

    /**
     * @param $cwd
     * @param GitRepositoryInterface $gitRepository
     */
    public static function push($cwd, GitRepositoryInterface $gitRepository)
    {
        chdir($cwd);
        passthru("git push origin {$gitRepository->getBranch()}");
    }
}
