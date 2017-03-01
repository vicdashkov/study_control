<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-14
 * Time: 9:59 PM
 *
 *
 *
 *  api is like controller that will communicate to db and will return html at jquery request
 * (but it will not talk to db or render any html by itself)
 */

include "Main_controller.php";


if($_POST[method] == "createNewTransaction") {
    create_new_transaction();
}

if($_POST[method] == "updateTransaction") {
    update_transaction();
}

if($_POST[method] == "completeTransaction") {
    complete_transaction();
}

if($_POST[method] == "updateTable") {
    $ctr = new Controller();
    $ctr->display_main_table();
}

if ($_POST[method] == "updateUnitButtonsDiv") {
    $ctr = new Controller();
    $ctr->display_unit_buttons_controller();
}

if ($_POST[method] == "addUserSubject") {
    $subject_id = $_POST[subject_id];
    $ctr = new Controller();


//    print_r($_POST);
    $ctr->add_user_subject($subject_id);

}

if($_POST[method] == 'updateMonthHeader') {
    $ctr = new Controller();
    $ctr->display_months_header();
}