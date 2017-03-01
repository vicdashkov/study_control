<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-01-30
 * Time: 11:02 PM
 */
class Time_table
{
//    private $_weeks;
    private $_months;

//    public function __construct($weeks)
//    {
//
//        $this->_weeks = $weeks;
//    }

    public function __construct($month)
    {

        $this->_months = $month;
    }

    public function display_old($weeks)
    {
        if (sizeof($weeks) == 0) {
            $this->_display_empty_week();
        } else {
            echo '<div id="time-table">';
            foreach ($weeks as $week) {

                $this->_display_week($week);
            }
            echo '</div>';
        }
    }

    public function display()
    {
//        echo '<br><br><br><br><br><br>';echo '<br><br><br><br><br><br>';


        if (sizeof($this->_months) == 0) {
            $month = new Month();
            $month->fill_up(null);
//            $this->_display_month($month);
            array_push($this->_months, $month);
        }

        $i = 0;
        $number_months = sizeof($this->_months);

        echo '<div id="time-table">';

        foreach ($this->_months as $month) {

            $month_number = $month->get_month_number();

            $dateObj = DateTime::createFromFormat('!m', $month_number);
            $month_date = $dateObj->format('F'); // March
            $year = $month->get_month_year();

            $id_name = $month_date . '-' . $year;


            if ($i == $number_months - 1) {
                echo '<div class="month active-month" id="' . $id_name . '">';
                $this->_display_month($month);
                echo '</div>'; // end of month div
            } else {
                echo '<div class="month" id="' . $id_name . '">';
                $this->_display_month($month);
                echo '</div>'; // end of month div
            }
            $i++;
        }

        echo '</div>'; // end of time-table
    }

    private function _display_month($month)
    {
        $weeks = $month->getWeeks();

//        echo '_display_month has this many weeks: ' . sizeof($weeks);

        foreach ($weeks as $week) {
            $this->_display_week($week);
        }

//        $this->_display_week($week);


    }

    private function is_same_month($current_week, $next_week)
    {
        $current_week_sunday = $current_week->getSundayDate();
        $next_week_sunday = $next_week->getSundayDate();

        // n - numeric representation of a month, without leading zeros
        if ($current_week_sunday->format("n") == $next_week_sunday->format("n")) {
            return true;
        } else {
            return false;
        }
    }

    private function _display_empty_week($week)
    {

        $sunday = new DateTime();
        $sunday->setTimestamp($week->getSundayDate()->getTimestamp());

        echo '<div class="week">';

        for ($i = 0; $i < 7; $i++) {
            $this->_display_empty_day($sunday);
            $sunday->modify('+1 day');
        }

        echo '</div>';
    }

    private function _display_week($week)
    {
        if ($week->isIsFilledUp() == false) {
            $this->_display_empty_week($week);
        } else {
            $days = $week->getDaysArray();

            $sunday = new DateTime();
            $sunday->setTimestamp($week->getSundayDate()->getTimestamp());

            echo '<div class="week">';
            foreach ($days as $day_number => $day) {
                if ($day->isInitialized()) {
                    $this->_display_day($day);
                } else {
                    $this->_display_empty_day($sunday);
                }
                $sunday->modify('+1 day');
            }
            echo '</div>';
        }
    }

    private function _display_empty_day($date)
    {
        echo '<div class="day">';
        echo '<div class="date unit">' . $date->format('F j') . '</div>';
        $i = 0;
        while ($i < 10) {
            echo '<div class="empty-unit unit"></div>';
            $i++;
        }

        echo '<div class="day-divider unit"></div>';

        $i = 0;
        while ($i < 6) {
            echo '<div class="empty-unit unit non-acad"></div>';
            $i++;
        }
        echo '</div>'; // end of day div
    }

    private function _display_unit($unit)
    {
        echo '<div class="subject-id-' . $unit->getSubjectid() . ' unit">' . strtoupper(substr($unit->getName(), 0, 1)) . '</div>';
    }

    private function _display_day($day)
    {
        echo '<div class="day">';
        echo '<div class="date unit">' . $day->get_date()->format('F j') . '</div>';
        $i = 0;
        foreach ($day->getAcadUnits() as $unit) {
            $this->_display_unit($unit);
            $i++;
        }
        while ($i < 10) {
            echo '<div class="empty-unit unit"></div>';
            $i++;
        }
        // end of displaying acad units

        echo '<div class="day-divider unit"></div>';

        // displaying non-acad units
        $i = 0;
        foreach ($day->getNonAcadUnits() as $unit) {
            $this->_display_unit($unit);
            $i++;
        }
        while ($i < 6) {
            echo '<div class="empty-unit unit non-acad"></div>';
            $i++;
        }
        echo '</div>'; // end of day div
    }
}