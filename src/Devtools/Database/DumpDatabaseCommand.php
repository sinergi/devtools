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
    public function generateTmpCwd()
    {
        $dir = tempnam(sys_get_temp_dir(), '');
        mkdir($dir);
        return $dir;
    }

    public function run()
    {
        echo '---------------------------------------------' . PHP_EOL;
        echo 'Dumping database ' . $this->database->getDatabaseName() . PHP_EOL;
        echo '---------------------------------------------' . PHP_EOL;

        Git::cloneRepository($this->cwd, $this->gitRepository);
    }
}
