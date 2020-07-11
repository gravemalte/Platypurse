<?php
namespace Model\DAO;

use Hydro\Base\Contracts\PlatypusDAOInterface;
use PDOException;


class PlatypusDAO implements PlatypusDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $query = "INSERT INTO platypus(p_id, name, age_years, sex, size, weight)
            VALUES (:platypusId, :name, :ageYears, :sex, :size, :weight)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":platypusId", $obj->getId());
        $stmt->bindValue(":name", $obj->getName());
        $stmt->bindValue(":ageYears", $obj->getAgeYears());
        $stmt->bindValue(":sex", $obj->getSex());
        $stmt->bindValue(":size", $obj->getSize());
        $stmt->bindValue(":weight", $obj->getWeight());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM platypus WHERE p_id = $id";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('PlatypusDAO create error');
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
            throw new PDOException('PlatypusDAO read error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE platypus SET name = :name, age_years = :ageYears, sex = :sex, size = :size,
                weight = :weight, active = :active WHERE p_id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":name", $obj->getName());
        $stmt->bindValue(":ageYears", $obj->getAgeYears());
        $stmt->bindValue(":sex", $obj->getSex());
        $stmt->bindValue(":size", $obj->getSize());
        $stmt->bindValue(":weight", $obj->getWeight());
        $stmt->bindValue(":active", $obj->isActive());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('PlatypusDAO update error');
        }
    }
}