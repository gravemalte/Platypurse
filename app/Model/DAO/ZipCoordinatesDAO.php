<?php
namespace Model\DAO;

use Hydro\Base\Contracts\ZipCoordinatesDAOInterface;
use PDOException;

class ZipCoordinatesDAO implements ZipCoordinatesDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function readByZipcode($zipcode)
    {
        $sql = "SELECT * FROM zip_coordinates WHERE zipcode = :zipcode";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":zipcode", $zipcode);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('ZipCoordinatesDAO readByZipcode error');
        }
    }
}