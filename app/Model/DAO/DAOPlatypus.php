<?php


namespace Model\DAO;
use http\Client\Curl\platypus;
use PDO;
use PDOException;

use Model\platypusModel;
use Hydro\Base\Contracts\DAOContract;


class DAOPlatypus implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $this->con->beginTransaction();
        $query = "INSERT INTO platypus(p_id, name, age_years, sex, size, weight)
            VALUES (:platypusId, :name, :ageYears, :sex, :size, :weight)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":platypusId", $obj->getId());
        $stmt->bindValue(":name", $obj->getName());
        $stmt->bindValue(":ageYears", $obj->getAge());
        $stmt->bindValue(":sex", $obj->getSex());
        $stmt->bindValue(":size", $obj->getSize());
        $stmt->bindValue(":weight", $obj->getWeight());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM platypus WHERE p_id = $id";
            $result = $this->con->query($sql);
            $this->con->commit();
            return $result->fetch();
        } else {
            $this->con->rollback();
            return new PDOException('DAOPlatypus create error');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM platypus WHERE p_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOPlatypus read error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE platypus SET name = :name, age_years = :ageYears, sex = :sex, size = :size,
                weight = :weight, active = :active WHERE p_id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":name", $obj->getName());
        $stmt->bindValue(":ageYears", $obj->getAge());
        $stmt->bindValue(":sex", $obj->getSex());
        $stmt->bindValue(":size", $obj->getSize());
        $stmt->bindValue(":weight", $obj->getWeight());
        $stmt->bindValue(":active", $obj->getActive());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOPlatypus update error');
        }
    }

    public function delete($id)
    {
    }

    public function readAll()
    {
        $sql = "SELECT * FROM platypus";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOPlatypus readAll error');
        }
    }
}