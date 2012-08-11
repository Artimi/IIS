<?php
/**
 * @author petr
 * Downloaded from: http://doc.nette.org/cs/quickstart/database
 */

namespace IIS;
use Nette;

/**
 * Reprezentuje repozitář pro databázovou tabulku
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

        if ($this->tableName === NULL) {
            $class = get_class($this);
            throw new Nette\InvalidStateException("Název tabulky musí být definován v $class::\$tableName.");
        }
    }

    /**
     * Vrací celou tabulku z databáze
     * @return \Nette\Database\Table\Selection
     */
    protected function getTable()
    {
        return $this->connection->table($this->tableName);
    }

    /**
     * Vrací všechny záznamy z databáze
     * @return \Nette\Database\Table\Selection
     */
    public function findAll()
    {
        return $this->getTable();
    }

    /**
     * Vrací vyfiltrované záznamy na základě vstupního pole
     * (pole array('name' => 'David') se převede na část SQL dotazu WHERE name = 'David')
     * @param array $by
     * @return \Nette\Database\Table\Selection
     */
    public function findBy(array $by)
    {
        return $this->getTable()->where($by);
    }

    /**
     * To samé jako findBy akorát vrací vždy jen jeden záznam
     * @param array $by
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function findOneBy(array $by)
    {
        return $this->findBy($by)->limit(1)->fetch();
    }

    /**
     * Vrací záznam s daným primárním klíčem
     * @param int $id
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function find($id)
    {
        return $this->getTable()->get($id);
    }
}