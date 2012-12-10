<?php

namespace BloodCenter;

/**
 * Model for 'nurse' table
 * 
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class Nurse extends Table
{

    protected $tableName = 'nurse';

    public function setPassword($id, $password)
    {
        $this->getTable()->where(array('id' => $id))->update(array(
            'password' => Authenticator::calculateHash($password)
        ));
    }
    
    public function generateNick($surname)
    {
        $nick = 'n' . strtolower(substr($surname, 0, 4));
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

}