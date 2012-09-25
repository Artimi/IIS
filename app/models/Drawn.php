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
        * Returns all drawns for user defined by $id
        * @param string $id
        * @return \Nette\Database\Table\Selection
        */
        public function getDrawnsById($id)
        {
            return $this->findBy(array('donor' => $id));
        }
}