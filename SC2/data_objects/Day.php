<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-01-23
 * Time: 5:16 PM
 */
class Day
{
    private $_acad_units;
    private $_non_acad_units;
    private $_date;

    public function __construct()
    {
        $this->_acad_units = array();
        $this->_non_acad_units = array();
        $this->_date = null;
    }

    public function fill_up($unit)
    {
        if ($unit->getSubjectType() == 1) {
            if ($this->_fill_up_helper($unit, $this->_non_acad_units)) {
                return true;
            }
        } else {
            if ($this->_fill_up_helper($unit, $this->_acad_units)) {
                return true;
            }
        }
        return false;
    }

    private function _fill_up_helper($unit, &$array)
    {
        if(!(is_null($this->_date))) {
            if ($this->_date->format('mdy') == $unit->getDate()->format('mdy')) {
                array_push($array, $unit);
            } else {
                return false;
            }
        } else {
            $this->_date = $unit->getDate();
            array_push($array, $unit);
        }
        return true;
    }

    public function get_week_day()
    {
        return $this->_date->format('w');
    }

    public function get_date()
    {
        return $this->_date;
    }

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return !is_null($this->_date);
    }

    /**
     * @return array
     */
    public function getAcadUnits()
    {
        return $this->_acad_units;
    }

    /**
     * @return array
     */
    public function getNonAcadUnits()
    {
        return $this->_non_acad_units;
    }

    public function __toString()
    {
        $number_units = 0;
        foreach ($this->_acad_units as $unit) {
            $number_units++;
        }

        return 'Day object [ number units: ' . $number_units . ' date is: ' . $this->get_date()->format('d/m/y') . ' ] ';
    }
}