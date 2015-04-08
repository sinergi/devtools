<?php

namespace Sinergi\Devtools\Database;

interface DatabaseInterface
{
    public function getHost();
    public function getDatabaseName();
    public function getUsername();
    public function getPassword();
}
