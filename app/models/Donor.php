<?php

namespace BloodCenter;

/**
 * Model for 'donor' table
 * @author xsebek02
 */
class Donor extends Table
{

    protected $tableName = 'donor';

    public function setPassword($id, $password)
    {
        $this->getTable()->where(array('id' => $id))->update(array(
            'password' => Authenticator::calculateHash($password)
        ));
    }

    public function generateNick($surname)
    {
        $nick = strtolower(substr($surname, 0, 5));
        $rows = $this->findLike(array('id' => $nick));
        if ($rows->count() != 0)
        {
            $numbers = array();
            foreach ($rows as $row)
            {
                $numbers[] = (int) substr($row['id'], 6, 2);
            }
            $number = max($numbers) + 1;
        }
        else
        {
            $number = 0;
        }
        return $nick . str_pad((string) $number, 2, '0', STR_PAD_LEFT);
    }
    
    /**
     * Returns information for user defined by $id
     * @param string $id
     * @return \Nette\Database\Table\ActiveRow|FALSE
     */
    public function getInfoById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }
    


}