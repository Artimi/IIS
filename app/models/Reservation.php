<?php

namespace BloodCenter;

/**
 * Model for 'reservation' table
 * @author xsebek02
 */

class Reservation extends Table
{
	protected $tableName = 'reservation';
        
        public function getReservationArray($withNull=TRUE)
        {
            $result = array();
            $table = $this->getTable();
            foreach ($table as $row)
            {
                $result[$row['id']] = $row['id']. ' | '.
                    $row['order_from']. ' | '.
                    $row['blood_type']. ' | '.
                    $row['quantity']. ' | '.
                    $row['date']. ' | '.
                    $this->reservationState[$row['state']];
            }
            if ($withNull)
            {
                $result[NULL] = '';
            }
            return $result;
        }
}