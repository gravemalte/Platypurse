<?php


namespace Model\DAO;
use PDOException;

use Hydro\Base\Contracts\DAOContract;


class DAOZipCoordinates implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj) { }

    public function read($id)
    {
        $query = "SELECT * FROM zip_coordinates WHERE zc_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOZipCoordinates read error');
        }
    }

    public function update($obj) { }

    public function delete($id) { }

    public function readAll()
    {
        $sql = "SELECT * FROM zip_coordinates";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOZipCoordinates readAll error');
        }
    }

    public function readByZipcode($zipcode)
    {
        $sql = "SELECT * FROM zip_coordinates WHERE zipcode = :zipcode";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":zipcode", $zipcode);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOZipCoordinates readByZipcode error');
        }
    }
}