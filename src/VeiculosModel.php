<?php

namespace App;

class VeiculosModel
{
    private $dbConnection;

    public function __construct()
    {
        $dbConnection  = new DbConnection();
        $this->dbConnection = $dbConnection->connect();
    }

    public function getAll()
    {
        try {
            $stmt = $this->dbConnection->prepare('SELECT * FROM veiculos');
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function save($data)
    {
        try {
            $stmt = $this->dbConnection->prepare('INSERT INTO veiculos (veiculo, marca, ano, descricao, vendido) VALUES (:veiculo, :marca, :ano, :descricao, :vendido)');
            $stmt->execute([
            ':veiculo' => $data->veiculo,
            ':marca' => $data->marca,
            ':ano' => $data->ano,
            ':descricao' => $data->descricao,
            ':vendido' => $data->vendido
            ]);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }

    public function find($query)
    {
        try {
            $stmt = $this->dbConnection->prepare('SELECT * FROM veiculos WHERE marca LIKE :query OR veiculo LIKE :query OR descricao LIKE :query OR ano LIKE :query');
            $stmt->execute([
            ':query' => '%' . $query . '%'
            ]);
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function update($data)
    {
        try {
            $stmt = $this->dbConnection->prepare('UPDATE veiculos SET (veiculo, marca, ano, descricao, vendido) VALUES (:veiculo, :marca, :ano, :descricao, :vendido) WHERE id = :id');
            $stmt->execute([
            ':veiculo' => $data->veiculo,
            ':marca' => $data->marca,
            ':ano' => $data->ano,
            ':descricao' => $data->descricao,
            ':vendido' => $data->vendido,
            ':id' => $data->id
            ]);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }
}
