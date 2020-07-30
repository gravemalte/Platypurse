<?php
namespace Model\DAO;

use Hydro\Base\Contracts\ReportDAOInterface;
use Model\OfferReportModel;
use PDOException;

class OfferReportDAO implements ReportDAOInterface
{
    private $con;

    /**
     * OfferReportDAO constructor.
     * @param $con
     */
    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * Returns the current connection
     * @return mixed
     */
    public function getCon() {
        return $this->con;
    }

    /**
     * Insert entry into database
     * @param OfferReportModel $obj
     * @return mixed
     */
    public function create($obj)
    {
        $query = "INSERT INTO offer_reports (or_id, reported_o_id, reporter_u_id, rr_id, message)
            VALUES (:id, :offerId, :userId, :reportReasonId, :message);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":offerId", $obj->getReportedObject()->getId());
        $stmt->bindValue(":userId", $obj->getReporterUser()->getId());
        // TODO: Implement report reason to match use in frontend
        // $stmt->bindValue(":reportReasonId", $obj->getReportReason()[0]);
        // $stmt->bindValue(":message", $obj->getUserId());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM offer_reports WHERE or_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            throw new PDOException('OfferReportDAO create error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read entry by id from database
     * @param $id
     * @return mixed
     */
    public function read($id)
    {
        $sql = "SELECT * FROM offer_reports
                WHERE or_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferReportDAO read error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read all entries from database
     * @return mixed
     */
    public function readAll()
    {
        $sql = "SELECT * FROM offer_reports;";

        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferReportDAO readAll error ' . $stmt->errorInfo());
        }
    }

    /**
     * Update entry in database
     * @param OfferReportModel $obj
     * @return bool
     */
    public function update($obj)
    {
        $sql = "UPDATE offer_reports SET active = :active WHERE or_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":active", $obj->isActive());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('OfferReportDAO update error ' . $stmt->errorInfo());
        }
    }
}