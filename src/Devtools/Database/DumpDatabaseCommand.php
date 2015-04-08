<?php

namespace Sinergi\Devtools\Database;

class DumpDatabaseCommand
{
    /**
     * @var DatabaseInterface
     */
    protected $database;

    /**
     * @var GitRepositoryInterface
     */
    protected $gitRepository;

    public function __construct(DatabaseInterface $database, GitRepositoryInterface $gitRepository)
    {
        $this->database = $database;
        $this->gitRepository = $gitRepository;
        $this->cwd = $this->generateTmpCwd();
    }

    /**
     * @return string
     */
    private function generateTmpCwd()
    {
        $dir = tempnam(sys_get_temp_dir(), '');
        unlink($dir);
        mkdir($dir, 0777, true);
        return $dir;
    }

    public function run()
    {
        echo '---------------------------------------------' . PHP_EOL;
        echo 'Dumping database ' . $this->database->getDatabaseName() . PHP_EOL;
        echo '---------------------------------------------' . PHP_EOL;

        Git::cloneRepository($this->cwd, $this->gitRepository);
        $this->dumpDatabase();
        Git::commit($this->cwd, $this->gitRepository);
        Git::push($this->cwd, $this->gitRepository);
    }

    private function dumpDatabase()
    {
        passthru("mysqldump -h {$this->database->getHost()} " .
            "-u {$this->database->getUsername()} " .
            "-p{$this->database->getPassword()} " .
            "{$this->database->getDatabaseName()} > {$this->cwd}/develop.sql");

        echo $this->cwd.PHP_EOL;
    }
}
