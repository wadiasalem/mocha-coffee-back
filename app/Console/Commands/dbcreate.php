<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MySQL database if not exist based on the database config file ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $schemaName = $this->argument('name') ?: config("database.connections.mysql.database");
        $charset = config("database.connections.mysql.charset",'utf8mb4');
        $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

        try {
            $pdo = $this->getPDOConnection
                (
                env('DB_HOST'),
                env('DB_PORT'), 
                env('DB_USERNAME'), 
                env('DB_PASSWORD'));

            $pdo->exec("CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;");

            $this->info(sprintf('Successfully created %s database', $schemaName));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $schemaName, $exception->getMessage()));
        }

        return Command::SUCCESS;
    }

    /**
     * @param  string $host
     * @param  integer $port
     * @param  string $username
     * @param  string $password
     * @return PDO
     */
    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
