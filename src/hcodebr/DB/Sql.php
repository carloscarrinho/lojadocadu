<?php

namespace Hcode\DB;

use PDO;

class Sql
{
    const HOSTNAME = CONF_DB_HOSTNAME;
    const USERNAME = CONF_DB_USERNAME;
    const PASSWORD = CONF_DB_PASSWORD;
    const DBNAME = CONF_DB_NAME;

    private $conn;

    public function __construct(string $env = "app")
    {
        if ($env === "test") {
            $this->conn = new \PDO(
                "mysql:dbname=" . CONF_DB_NAME_TEST . ";host=" . CONF_DB_HOSTNAME,
                CONF_DB_USERNAME,
                CONF_DB_PASSWORD
            );
            return;
        }

        $this->conn = new \PDO(
            "mysql:dbname=" . CONF_DB_NAME . ";host=" . CONF_DB_HOSTNAME,
            CONF_DB_USERNAME,
            CONF_DB_PASSWORD
        );
    }

    private function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->bindParam($statement, $key, $value);
        }
    }

    private function bindParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array())
    {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
    }

    public function select($rawQuery, $params = array()): array
    {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
