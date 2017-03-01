<?php

/**
 * User: vic
 * Date: 2017-01-23
 * Time: 5:11 PM
 */
class Week
{

    private $_days_array;
    private $_sunday_date;
    private $_is_filled_up;


    // $sunday_date could be null and shuld be if fill_up will be use, pass null if it is supposedly an empty week
    public function __construct($sunday_date)
    {
        $this->_days_array = array(
            0 => new Day(),
            1 => new Day(),
            2 => new Day(),
            3 => new Day(),
            4 => new Day(),
            5 => new Day(),
            6 => new Day(),
        );
        $this->_sunday_date = $sunday_date;
        $this->_is_filled_up = false;
    }

    public function fill_up($day)
    {
        $this->_is_filled_up = true;

        if (!is_null($this->_sunday_date)) {
            if ($this->_check_same_week($day->get_date())) {
                $this->_days_array[$day->get_week_day()] = $day;
            } else {
                return false;
            }
        } else {
            $this->_sunday_date = $this->_get_last_sunday($day);
            $this->_days_array[$day->get_week_day()] = $day;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isIsFilledUp()
    {
        return $this->_is_filled_up;
    }

    public function __toString()
    {
        return 'Week object [Sunday date is: ' . $this->_sunday_date->format('d / m / Y') .
            ' _is_filled_up: ' . $this->_is_filled_up . ']';
    }

    /**
     * @return DateTime
     */
    public function getSundayDate()
    {
        return $this->_sunday_date;
    }

    /**
     * @return array
     */
    public function getDaysArray()
    {
        return $this->_days_array;
    }

    public function getWeekNumber()
    {
        $week_number = $this->getSundayDate()->format("W");
        return $week_number + 0;
    }

    public function get_month_number()
    {
        $month_number = $this->getSundayDate()->format("n");
        return $month_number + 0;
    }

    private function _check_same_week($date)
    {
        $passed_week_number = $date->format("W");
        $this_week_number = $this->_sunday_date->format("W");

        $this_week_number++;

        if ($date->format('w') == 0) {
            $passed_week_number++;
        }

        if ($passed_week_number == $this_week_number) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * now seem to work fine
     * @param $day
     * @return DateTime
     */
    private function _get_last_sunday($day)
    {
//        echo 'displaying day: ' . $day . ' <br>';

        $date = $day->get_date();

        $date_time = new DateTime();
        if ($date->format('w') == 0) {
            $date_time = $date;
        } else {
            $date_time->setTimestamp(strtotime('last Sunday', $date->getTimestamp()));
        }

        return $date_time;
    }


}