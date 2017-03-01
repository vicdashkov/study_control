<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-01-23
 * Time: 5:29 PM
 */
class Converter
{
    const SIZE_MINUTES = 30;

    private $_transactions;
    private $_leftovers;
    private $_weeks;
    private $_units;
    private $_mysqli_result;
    private $_days;
    private $_months;

    public function __construct($mysqli_result)
    {
        $this->_mysqli_result = $mysqli_result;

        $this->_units = array();
        $this->_leftovers = array();
        $this->_transactions = array();
        $this->_weeks = array();
        $this->_days = array();
        $this->_months = array();

        $this->_initialize();
    }

    private function _initialize()
    {
        if ($this->_mysqli_result->num_rows > 0) {
            $this->_transactions_to_units();
            if (sizeof($this->_units) != 0) {
                $this->_units_to_days();
                $this->_days_to_weeks();
                $this->_weeks_to_month();
            }

        } else {
//            $this->_units = null;
//            $this->_leftovers = null;
//            $this->_transactions = null;
//            $this->_weeks = null;
//            $this->_days = null;
        }
    }


    private function _weeks_to_month()
    {
        $month = new Month();

        foreach ($this->_weeks as $week) {
            if ($month->fill_up($week)) {

            } else {
                array_push($this->_months, $month);
                $month = new Month();
                $month->fill_up($week);
            }
        }
        array_push($this->_months, $month);

//
//        echo '<br><br><br><br><br><br>';
//        echo 'converter has this many month     ' . sizeof($this->_months);
    }

    /**
     * @return array
     */
    public function getMonths()
    {
        return $this->_months;
    }

    private function _days_to_weeks()
    {

//        echo ' inside _days_to_weeks ';

//        echo '<br>';
//        echo sizeof($this->_days);
//        echo '<br>';


        $week = new Week(null);

//        echo '<br><br><br><br><br><br>';
        foreach ($this->_days as $day) {


            if ($week->fill_up($day)) {
            } else {
                array_push($this->_weeks, $week);
                $week = new Week(null);
                $week->fill_up($day);
            }
        }
        array_push($this->_weeks, $week);


    }


    private function _transactions_to_units()
    {
        $i = 0;
        while ($r = mysqli_fetch_assoc($this->_mysqli_result)) {

//            echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
//            print_r($r);
//            echo '<br>';

            // :1

//echo ' inside _transactions_to_units ';


            $start = new DateTime($r[start_time]);
            $end = new DateTime($r[end_time]);

            $type_id = $r[type_id];
            $name = $r[name];
            $description = $r[description];
            $subject_type = $r[subject_type];
            $active = $r[active];
            $color = $r[color];

            $duration = round(abs($end->getTimestamp() - $start->getTimestamp()) / 60, 2);

//            echo ' <br>start:  ' . $start->format('m / d / y');
//            echo ' <br>end:  ' . $end->format('m / d / y');


//            echo '<br>';
//            echo '<br>';
//            print_r($r);
//            echo '<br>';

            // :2
            if ($duration >= Converter::SIZE_MINUTES) {
                while ($duration >= Converter::SIZE_MINUTES) {
                    $time_unit = new Unit($i, $type_id, $name, $description, $subject_type, $active, $color);
                    $time_unit->set_date($end);
                    $time_unit->setDuration(30);
                    array_push($this->_units, $time_unit);
                    $duration = $duration - Converter::SIZE_MINUTES;
                    $i++;
                }
            }

            // :3
            if (isset($this->_leftovers[$type_id])) {
                $this->_leftovers[$type_id]->setDuration($this->_leftovers[$type_id]->getDuration() + $duration);
            } else {
                $this->_leftovers[$type_id] = new Unit($i, $type_id, $name, $description, $subject_type, $active,$color);
                $this->_leftovers[$type_id]->setDuration($duration);
                $i++;


//                echo '[[[[[test}}}}';
            }

            // :4
            if ($this->_leftovers[$type_id]->getDuration() >= 30) {

                $time_unit = new Unit($i, $type_id, $name, $description, $subject_type, $active,$color);
                $time_unit->setDuration(30);
                $time_unit->set_date($end);
                array_push($this->_units, $time_unit);

                $new_duration = ($this->_leftovers[$type_id]->getDuration() - Converter::SIZE_MINUTES);
                $this->_leftovers[$type_id]->setDuration($new_duration);
                $i++;
            }
        }

//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        foreach ($this->_leftovers as $leftover) {
//            echo $leftover;
//        }
//        echo '<br>';

//        echo '<br><br><br><br><br><br>displaying units after _transactions_to_units method:<br>';
//        foreach ($this->_units as $unit) {
//            echo $unit;
//            echo '<br>';
//        }
//        echo '<br><br><br>';
    }

    /**
     * this function seems to produce correct results
     */
    private function _units_to_days()
    {


//        echo ' inside _units_to_days ';


        $day = new Day();
        foreach ($this->_units as $unit) {

//            echo "<br>unit: " . $unit . "<br>";


            if ($day->fill_up($unit)) {

            } else {
                array_push($this->_days, $day);
                $day = new Day();
                $day->fill_up($unit);
            }
        }
        array_push($this->_days, $day);
    }


    /**
     * @return array
     */
    public function getTransactions()
    {
        return $this->_transactions;
    }

    /**
     * @return array
     */
    public function getLeftovers()
    {
        return $this->_leftovers;
    }

    /**
     * @return array
     */
    public function getWeeks()
    {
        return $this->_weeks;
    }

    /**
     * @return array
     */
    public function getUnits()
    {
        return $this->_units;
    }

    /**
     * @return mixed
     */
    public function getMysqliResult()
    {
        return $this->_mysqli_result;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->_days;
    }

}