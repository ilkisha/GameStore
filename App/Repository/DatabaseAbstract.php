<?php


namespace App\Repository;


use Core\DataBinderInterface;
use Database\DatabaseInterface;

class DatabaseAbstract
{
    /**
     * @var DatabaseInterface
     */
    protected $db;
    /**
     * @var DataBinderInterface
     */
    private $dataBinder;

    public function __construct(DatabaseInterface $database, DataBinderInterface $dataBinder)
    {
        $this->db = $database;
        $this->dataBinder = $dataBinder;
    }
}