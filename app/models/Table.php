<?php

/**
 * @author petr
 * Downloaded from: http://doc.nette.org/cs/quickstart/database
 */

namespace BloodCenter;

use Nette;

/**
 * Represent repository for given database table
 */
abstract class Table extends Nette\Object
{

    /** @var Nette\Database\Connection */
    protected $connection;

    /** @var string */
    protected $tableName;

    /**
     * @param Nette\Database\Connection $db
     * @throws \Nette\InvalidStateException
     */
    public function __construct(Nette\Database\Connection $db)
    {
        $this->connection = $db;

        if ($this->tableName === NULL)
        {
            $class = get_class($this);
            throw new Nette\InvalidStateException("Name of table have to be defined in $class::\$tableName.");
        }
    }

    /**
     * Returns whole table
     * @return \Nette\Database\Table\Selection
     */
    protected function getTable()
    {
        return $this->connection->table($this->tableName);
    }

    /**
     * Returns every record from table
     * @return \Nette\Database\Table\Selection
     */
    public function findAll()
    {
        return $this->getTable();
    }

    /**
     * Returns filtered records according to array $by
     * array('name' => 'David') means in SQL WHERE name = David
     * @param array $by
     * @return \Nette\Database\Table\Selection
     */
    public function findBy(array $by)
    {
        return $this->getTable()->where($by);
    }

    /**
     * Same as findBy, but returns just one record
     * @param array $by
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function findOneBy(array $by)
    {
        return $this->findBy($by)->limit(1)->fetch();
    }

    /**
     * Returns record with given primary key
     * @param int $id
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function find($id)
    {
        return $this->getTable()->get($id);
    }

    public function findOffset($offset, $itemsPerPage)
    {
        return $this->getTable()->limit($itemsPerPage, $offset);
    }
    
    public function getCount()
    {
        return $this->getTable()->count();
    }
}