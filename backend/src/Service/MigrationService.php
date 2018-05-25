<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class MigrationService
{
    /** @var Connection */
    private $connection;

    /** @var Connection */
    private $oldConnection;

    public function __construct(Connection $db, Connection $old)
    {
        $this->connection = $db;
        $this->oldConnection = $old;
    }

    public function getOldDataFromTable($table)
    {
        print_r($this->oldConnection);
        return $this->oldConnection->query(sprintf('SELECT * FROM %s', $table))->fetchAll();
    }
}