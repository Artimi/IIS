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
    
    public function createNick($surname)
    {
        $nick = strtolower(substr($surname,0,5));
        return $nick.'00'; //TODO uniqueness control
    }

}