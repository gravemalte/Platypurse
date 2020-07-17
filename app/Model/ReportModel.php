<?php

namespace Model;

class ReportModel {
    private $id;
    private $reportedObject;
    private $reporterUser;
    private $reportReason;
    private $message;
    private $active;

    /**
     * ReportModel constructor.
     * @param $id
     * @param $reportedObject
     * @param $reporterUser
     * @param $reportReason
     * @param $message
     * @param $active
     */
    public function __construct($id, $reportedObject, $reporterUser, $reportReason, $message, $active)
    {
        $this->id = $id;
        $this->reportedObject = $reportedObject;
        $this->reporterUser = $reporterUser;
        $this->reportReason = $reportReason;
        $this->message = $message;
        $this->active = $active;
    }

    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    public function updateInDatabase($dao) {
        return $dao->update($this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getReportedObject()
    {
        return $this->reportedObject;
    }

    /**
     * @param mixed $reportedObject
     */
    public function setReportedObject($reportedObject): void
    {
        $this->reportedObject = $reportedObject;
    }

    /**
     * @return mixed
     */
    public function getReporterUser()
    {
        return $this->reporterUser;
    }

    /**
     * @param mixed $reporterUser
     */
    public function setReporterUser($reporterUser): void
    {
        $this->reporterUser = $reporterUser;
    }

    /**
     * @return mixed
     */
    public function getReportReason()
    {
        return $this->reportReason;
    }

    /**
     * @param mixed $reportReason
     */
    public function setReportReason($reportReason): void
    {
        $this->reportReason = $reportReason;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }
}