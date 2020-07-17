<?php
namespace Hydro\Base\Contracts;

interface ReportDAOInterface
{
    public function create($obj);
    public function read($id);
    public function readAll();
    public function update($obj);
}