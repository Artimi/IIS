<?php

namespace BloodCenter;

/**
 * Model for 'drawn' table
 * @author xsebek02
 */
class Drawn extends Table
{
	protected $tableName = 'drawn';
        
        /**
        * Returns all drawns for user defined by $donor
        * @param string $id
        * @return \Nette\Database\Table\Selection
        */
        public function getDrawnsByDonor($donor)
        {
            return $this->findBy(array('donor' => $donor));
        }
        
        /**
        * Returns the drawn defined by $id
        * @param string $id
        * @return \Nette\Database\Table\ActiveRow|FALSE
        */
        public function getDrawnById($id)
        {
            return $this->findOneBy(array('id' => $id));
        }
}