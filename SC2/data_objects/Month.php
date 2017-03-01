<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-14
 * Time: 11:51 PM
 */
class Month
{
    private $_weeks;
    private $_first_day_month;
    private $_is_initialized;


    /**
     * @return array
     */
    public function getWeeks()
    {

        return $this->_weeks;
    }


    public function __construct()
    {
        $this->_weeks = array();
        $this->_first_day_month = null;
        $this->_is_initialized = false;
    }

    function __destruct()
    {
//        echo '<br>[destructor for Month object with this first day: ' . $this->_first_day_month->format(' d / m / y');
//        echo '; I have this many weeks: ' . sizeof($this->_weeks);
//        echo '<br>and my weeks are:<br> ';
//        foreach ($this->_weeks as $key => $week) {
//            echo $key . '=>' . $week;
//            echo '<br>';
//        }
//        echo '<br>this->_first_day_month is: ' . $this->_first_day_month->format(' d/ m / y');
//        echo '<br>end destructor]<br>';
    }

    public function fill_up($week)
    {

        if ($week == null ) {
            $this->_initialize(null);
        } else {
            if ($this->_is_initialized) {
//                    echo '<br>working on this week: ' . $week->getWeekNumber();
                if ($this->get_month_number() == $week->get_month_number()) {
                    $this->_weeks[$week->getWeekNumber()] = $week;
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->_initialize($week);
                $this->_weeks[$week->getWeekNumber()] = $week;
                return true;
            }
        }
    }


    private function _initialize($week)
    {
//        echo '<br>initilizing; i should run only one time at the object creation time';

        if($week == null) {
            $this->_is_initialized = true;
            $this->_set_first_day_month(new DateTime());
        } else {
            $this->_is_initialized = true;

            $this->_set_first_day_month($week->getSundayDate());
        }

//        $day = new DateTime($this->_first_day_month);
            $date = $this->_first_day_month;
            $week = new Week($date);
//
            while ($this->get_month_number() == $week->get_month_number()) {

                $this->_weeks[$week->getWeekNumber()] = $week;
                $date = new DateTime();
                $date->setTimestamp($week->getSundayDate()->getTimestamp());

                $date->add(new DateInterval('P7D'));
                $week = new Week($date);
            }


//        $this->_weeks[$week->getWeekNumber()] = $week;


//        echo '<br>weeks after initializing:<br> ';
//        foreach ($this->_weeks as $key => $week) {
//            echo $key . '=>' . $week;
//            echo '<br>';
//        }
//        echo 'and weeks after initializing]<br>';

    }

    private function _set_first_day_month($date)
    {
        $this->_first_day_month = $this->_get_month_first_sunday($date);
//        echo '<br>i set first day month to this: ' . $this->_first_day_month->format('m / d / Y');
    }

    private
    function _get_month_first_sunday($date)
    {
        $return_date = new DateTime(date("Y-m-d", strtotime("first Sunday of " . $date->format('M Y'))));
        return $return_date;
    }

    public function get_month_number()
    {
        $month_number = $this->_first_day_month->format("n");
        return $month_number + 0;
    }

    public function get_month_year()
    {
        $year_number = $this->_first_day_month->format("Y");
        return $year_number + 0;
    }

    private function _is_same_month($date)
    {
//        echo '<br>';
//        echo '_is_same_month passing date is:     ' . $date->format('d / m / y');
//        echo '<br>_is_same_month this->_first_day_month is: '. $this->_first_day_month->format('d / m / y');


        if ($this->_first_day_month->format("n") == $date->format("n")) {
//            echo '<br>_is_same_month returns true';
            return true;
        } else {
//            echo '<br>_is_same_month returns false';
            return false;
        }
    }

    public
    function __toString()
    {
        return 'Month object 
            [Month first day is: ' . $this->_first_day_month->format('d / m / Y') .
            ' Number of weeks: ' . sizeof($this->_weeks) .
            ']';
    }
}