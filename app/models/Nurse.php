<?php

namespace BloodCenter;

/**
 * Model for 'nurse' table
 * @author xsebek02
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

}