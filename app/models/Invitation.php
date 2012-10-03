<?php

namespace BloodCenter;

/**
 * Model for 'Invitaion' table
 * @author xsebek02
 */
class Invitation extends Table
{
	protected $tableName = 'invitation';
        
        /**
        * Returns all invitations for user defined by $id
        * @param string $id
        * @param int $state State of the invitation (0=in progress)
        * @return \Nette\Database\Table\Selection
        */
        public function getInvitationsByDonor($id, $state=-1)
        {
            if ($state == -1)
                return $this->findBy(array('donor' => $id));
            else    
                return $this->findBy(array('donor' => $id, 'state' => $state));
        }
                
        
        /**
         * Returns if the user defined by $id has any invitations or not
         * @param string $id
         * @return boolean
         */
        public function hasInvitations($id, $state=-1)
        {
            if ($state == -1)
                if ($this->findBy(array('donor' => $id))->count() > 0)
                    return TRUE;
                else
                    return FALSE;
            else
                if ($this->findBy(array('donor' => $id, 'state' => $state))->count() > 0)
                    return TRUE;
                else
                    return FALSE;
        }
}