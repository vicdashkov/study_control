<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-15
 * Time: 8:35 PM
 */

session_start();

include ('model/db.config.php');
include('model/Database.php');
include('data_objects/Day.php');
include('data_objects/Unit.php');
include('data_objects/Month.php');
include('data_objects/Week.php');
include('utils/Converter.php');
include('views/Time_table.php');
include('views/Stopwatch.php');
include('views/start_button.php');
include 'views/subject_list.php';
include 'model/db_interface.php';
include('views/months_header.php');
include ('views/unit_buttons_div.php');
include ('views/Table_styles.php');

class Controller
{

    private $_converter;
    private $_connection;

    public function __construct()
    {
        $this->_connection = Database::getInstance()->getConnection();
        $this->_setup_converter();
    }

    private function _setup_converter()
    {
        $sql_result = get_all_transaction();
        $this->_converter = new Converter($sql_result);
    }

    public function __destruct()
    {
        $this->_connection->close();
    }

    public function display_table_styles()
    {
        $table_styles = new Table_styles();
        $table_styles->display(get_user_subject());
    }

    public function display_months_header()
    {
        $result = get_user_info();
        $row = $result->fetch_assoc();

        display_months_header($this->_converter->getMonths(), $row[fname] . ' ' . $row[lname]);
    }

    public function display_control_panel()
    {

        $result = get_user_info();
        $row = $result->fetch_assoc();


        display_control_panel($this->_converter, $row[fname] . ' ' . $row[lname]);
    }

    public function display_unit_buttons_controller(){

        display_unit_buttons($this->_converter);
    }

    public function display_subjects()
    {
        $mysql_result = get_subjects();
        display_subjects($mysql_result);
    }

    public function display_main_table()
    {

        $months = $this->_converter->getMonths();


        $display_time_table = new Time_table($months);


//        $weeks = $this->_converter->getWeeks();
        $display_time_table->display();
    }

    public function display_stopwatch()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->display("yellow", 20);
    }

    public function add_user_subject($subject_id)
    {
        // call to CRUD. FIX ALL OF THIS MESS!!
        add_subject_user($subject_id);
    }
}