<?php
namespace Model;

use Model\DAO\OfferDAO;
use Model\DAO\UserDAO;

class OfferReportModel extends ReportModel {
    public function __construct($id, $reportedObject, $reporterUser, $reportReason, $message, $active)
    {
        parent::__construct($id, $reportedObject, $reporterUser, $reportReason, $message, $active);
    }

    public static function getFromDatabase($dao, $id) {
        $userDao = new UserDAO($dao->getCon());
        $offerDao = new OfferDAO($dao->getCon());
        $result = $dao->read($id);

        return new ReportModel($result[0],
            OfferModel::getFromDatabase($offerDao, $result[1]),
            UserModel::getFromDatabaseById($userDao ,$result[2]),
            $result[3], $result[4], $result[5]);
    }

    public function getAllFromDatabase($dao) {
        $userDao = new UserDAO($dao->getCon());
        $offerDao = new OfferDAO($dao->getCon());
        $result = $dao->readAll();

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ReportModel($row[0],
                OfferModel::getFromDatabase($offerDao, $row[1]),
                UserModel::getFromDatabaseById($userDao ,$row[2]),
                $row[3], $row[4], $row[5]);
        endforeach;

        return $returnArray;
    }
}