<?php
namespace Model;

use Model\DAO\UserDAO;
use Model\DAO\UserReportDAO;

class UserReportModel extends ReportModel {
    /**
     * UserReportModel constructor.
     * @param $id
     * @param $reportedObject
     * @param $reporterUser
     * @param $reportReason
     * @param $message
     * @param $active
     */
    public function __construct($id, $reportedObject, $reporterUser, $reportReason, $message, $active)
    {
        parent::__construct($id, $reportedObject, $reporterUser, $reportReason, $message, $active);
    }

    /**
     * Returns model by id from database
     * @param UserReportDAO $dao
     * @param $id
     * @return ReportModel
     */
    public static function getFromDatabase($dao, $id) {
        $userDao = new UserDAO($dao->getCon());
        $result = $dao->read($id);

        return new ReportModel($result[0],
            UserModel::getFromDatabaseById($userDao, $result[1]),
            UserModel::getFromDatabaseById($userDao ,$result[2]),
            $result[3], $result[4], $result[5]);
    }

    /**
     * Returns all models from database
     * @param UserReportDAO $dao
     * @return array
     */
    public function getAllFromDatabase($dao) {
        $userDao = new UserDAO($dao->getCon());
        $result = $dao->readAll();

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ReportModel($row[0],
                UserModel::getFromDatabaseById($userDao, $row[1]),
                UserModel::getFromDatabaseById($userDao ,$row[2]),
                $row[3], $row[4], $row[5]);
        endforeach;

        return $returnArray;
    }
}