<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-01
 * Time: 9:06 PM
 */
//include('Database.php');

//$user_id = $_SESSION[$user_id];

/**
 *           this looks a whole lot like a class with destructor that closes the connection
 *          should i at all close the connection??????
 */


function get_user_subject()
{
    $user_id = $_SESSION[user_id];
    $connection = Database::getInstance()->getConnection();

    $sql = "SELECT * FROM user_subjects WHERE user_id='$user_id'";

    $result = mysqli_query($connection, $sql);

    return $result;
}

function add_subject_user($subject_id)
{

    $user_id = $_SESSION[user_id];

    $connection = Database::getInstance()->getConnection();


    $sql = "INSERT INTO  user_subjects (user_id, subject_id, active)
            VALUES ($user_id, $subject_id, 1 );";


    if ($connection->query($sql) === TRUE) {
        echo "create_new_transaction success";
    } else {
        echo "create_new_transaction Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}

function get_user_info()
{
    $user_id = $_SESSION[user_id];
    $connection = Database::getInstance()->getConnection();

    $sql = "SELECT * FROM users WHERE id='$user_id'";

    $result = mysqli_query($connection, $sql);

    return $result;
}

function get_subjects()
{
    $connection = Database::getInstance()->getConnection();
    $user_id = $_SESSION[user_id];

    $sql = "SELECT * 
            FROM subjects
            WHERE NOT 
            EXISTS (
            SELECT * 
            FROM user_subjects
            WHERE subjects.subject_id = user_subjects.subject_id
            AND user_subjects.user_id = $user_id
            )";

    $result = mysqli_query($connection, $sql);

    return $result;
}

function get_all_transaction()
{
    $user_id = $_SESSION[user_id];

    $connection = Database::getInstance()->getConnection();

    $selectQuery = "SELECT * 
                    FROM transactions
                    INNER JOIN subjects ON transactions.type_id = subjects.subject_id
                    INNER JOIN user_subjects ON transactions.type_id = user_subjects.subject_id
                    AND transactions.user_id = user_subjects.user_id
                    WHERE transactions.user_id =$user_id
                    ORDER BY transactions.id";
//                    AND user_subjects.active =1";


    $selectResult = mysqli_query($connection, $selectQuery);

    return $selectResult;
}

function epoch_to_sql_date($stamp_milliseconds)
{
    $date_time = new DateTime();
    $date_time->setTimestamp($stamp_milliseconds / 1000);

    return $date_time->format("Y-m-d H:i:s");
}

// be careful this doesn't close the connection.
function complete_all_transactions()
{
    $user_id = $_SESSION[user_id];
    $connection = Database::getInstance()->getConnection();

    $sql = "UPDATE transactions SET completed=1 WHERE completed=0 and user_id=$user_id";

    if ($connection->query($sql) === TRUE) {
        echo "complete_all_transactions sucess";
    } else {
        echo "complete_all_transactions error: " . $connection->error;
    }
}

function create_new_transaction()
{

    echo 'creating new transaction()';

    $user_id = $_SESSION[user_id];

    complete_all_transactions();

    $type = $_POST['type'];
    $start = epoch_to_sql_date($_POST['start']);
    $end = epoch_to_sql_date($_POST['start']);

    $connection = Database::getInstance()->getConnection();

    $sql = "INSERT INTO  transactions (id ,type_id ,start_time ,end_time ,completed, user_id) 
            VALUES (NULL,'$type','$start','$end','0','$user_id');";

    if ($connection->query($sql) === TRUE) {
        echo "create_new_transaction success";
    } else {
        echo "create_new_transaction Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}

function update_transaction()
{
    $user_id = $_SESSION[user_id];
    $end = epoch_to_sql_date($_POST['end']);

    $connection = Database::getInstance()->getConnection();

    $sql = "UPDATE transactions SET end_time='$end' WHERE completed=0 AND user_id=$user_id";

    if ($connection->query($sql) === TRUE) {
        echo "update_transaction sucess";
    } else {
        echo "update_transaction Error: " . $connection->error;
    }

    $connection->close();
}

function complete_transaction()
{
    $user_id = $_SESSION[user_id];
    $end = epoch_to_sql_date($_POST['end']);

    $connection = Database::getInstance()->getConnection();

    $sql = "UPDATE transactions SET end_time='$end', completed=1 WHERE completed=0 AND user_id=$user_id";

    if ($connection->query($sql) === TRUE) {
        echo "complete_transaction success";
    } else {
        echo "complete_transaction Error: " . $connection->error;
    }

    $connection->close();
}

//add_transaction();



