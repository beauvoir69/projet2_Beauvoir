<?php

class Crud
{
    public $connection;

    public function __construct($host, $db, $user, $password)
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $this->connection = new PDO($dsn, $user, $password);
            if ($this->connection) {
                //echo "Connected to the $db database successfully";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAll($table)
    {
        $PDOStatement = $this->connection->query("SELECT * FROM $table ORDER BY id ASC");
        $data = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getById($table, $id)
    {
        $PDOStatement = $this->connection->prepare("SELECT * FROM $table WHERE id = :id");
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->execute();
        $data = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getByOneColumn($table, $col, $value)
    {
        $PDOStatement = $this->connection->prepare("SELECT * FROM $table WHERE $col = :value");
        $PDOStatement->bindParam(':value', $value, PDO::PARAM_STR);
        $PDOStatement->execute();
        $data = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function add($table, $itemdata)
    {
        $columns = implode(", ", array_keys($itemdata));
        $values = ":" . implode(", :", array_keys($itemdata));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $PDOStatement = $this->connection->prepare($query);

        foreach ($itemdata as $key => $value) {
            $type = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $PDOStatement->bindValue(":$key", $value, $type);
        }

        $PDOStatement->execute();

        if ($PDOStatement->rowCount() <= 0) {
            return false;
        }
        return $this->connection->lastInsertId();
    }

    public function updateById($table, $id, $itemdata)
    {
        $setClause = implode(", ", array_map(fn ($key) => "$key = :$key", array_keys($itemdata)));
        $query = "UPDATE $table SET $setClause WHERE id = :id";

   
        
        $PDOStatement = $this->connection->prepare($query);
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);

        foreach ($itemdata as $key => $value) {
            $type = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $PDOStatement->bindValue(":$key", $value, $type);
        }

        $PDOStatement->execute();
    }

    public function delete($table, $id)
    {
        $PDOStatement = $this->connection->prepare("DELETE FROM $table WHERE id = :id");
        $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $PDOStatement->execute();

        return $PDOStatement->rowCount() > 0;
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}
