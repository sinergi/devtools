<?php

namespace Sinergi\Devtools\Database;

interface GitRepositoryInterface
{
    public function getRepository();
    public function getBranch();
}
