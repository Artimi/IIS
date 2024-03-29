<?php

namespace BloodCenter;

/**
 * Model for 'station' table
 * @author xsebek02
 */
class Station extends Table
{

    protected $tableName = 'station';

    public function getStationNames($withNull=FALSE)
    {
        $result = array();
        $table = $this->getTable();
        foreach ($table as $station)
        {
            $result[$station['id']] = $station['name'];
        }
        if ($withNull)
        {
            $result[NULL] = '';
        }
        return $result;
    }
}