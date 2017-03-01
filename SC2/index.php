<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-01-23
 * Time: 11:02 PM
 */

include 'Main_controller.php';

if(!isset($_SESSION[user_id])) {
    header("Location: login.php");
    die();
}

$controller = new Controller();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>StudyControl Main</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/styles_main_table.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stopwatch.css">
    <link rel="stylesheet" href="css/start_button.css">

    <script src="js/javascript.js"></script>
</head>
<body>
<?
$controller->display_table_styles();
$controller->display_stopwatch();
$controller->display_subjects();
?>

<div id="main-pane">
    <? $controller->display_main_table(); ?>
</div>

<?
$controller->display_months_header();
$controller->display_unit_buttons_controller();

?>
</body>
</html>


