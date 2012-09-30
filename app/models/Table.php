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
    public $bloodTypes = array('0-' => '0-',
        '0+' => '0+',
        'A-' => 'A-',
        'A+' => 'A+',
        'B-' => 'B-',
        'B+' => 'B+',
        'AB-' => 'AB-',
        'AB+' => 'AB+');
    public $reservationState = array(0 => 'in progress',
        1 => 'finished',
        2 => 'cancelled');
    public $invitationState = array(0 => 'in progress',
        1 => 'confirmed',
        2 => 'cancelled',
        3 => 'finished',
        4 => 'unfulfilled');

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

    public function update($data, $id)
    {
        $data = $this->replaceEmptyStringByNull($data);
        return $this->getTable()->where('id', $id)->update($data);
    }

    public function insert($data)
    {
        $data = $this->replaceEmptyStringByNull($data);
        return $this->getTable()->insert($data);
    }

    public function findLike($data)
    {
        $table = $this->getTable();
        foreach ($data as $key => $value)
        {
            $table = $table->where("$key" . ' LIKE ?', "%$value%");
        }
        return $table;
    }

    public function findOneByID($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    public function getIDs()
    {
        $result = array();
        $table = $this->getTable();
        foreach ($table as $row)
        {
            $result[$row['id']] = $row['id'];
        }
        return $result;
    }
    
    public function replaceEmptyStringByNull($array)
    {
        foreach($array as $key => $value)
        {
            if ($value == '')
            {
                $array[$key] = NULL; 
            }
        }
        return $array;
    }

}