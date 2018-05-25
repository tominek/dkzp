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
        return $this->oldConnection->query(sprintf('SELECT * FROM %s', $table))->fetchAll();
    }

    public function truncateAllTables()
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0;')->execute();

        $schemaManager = $this->connection->getSchemaManager();
        $tables = $schemaManager->listTables();
        $query = '';

        foreach($tables as $table) {
            $name = $table->getName();
            $query .= 'TRUNCATE ' . $name . ';';
        }
        $this->connection->executeQuery($query, [], []);
    }
}