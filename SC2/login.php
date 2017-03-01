<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-13
 * Time: 7:40 PM
 */

include 'Main_controller.php';



session_unset();
session_destroy();

$connection = Database::getInstance()->getConnection();

$username = $_POST[username];
$password = $_POST[password];
$first_name = $_POST[fname];
$last_name = $_POST[lname];
$email = $_POST[email];

function verify_user_password($user_id, $password, $connection)
{
    $query = "SELECT password FROM users WHERE id=$user_id";

    $result = $connection->query($query)->fetch_assoc();
    $stored_hash = $result[password];

    return password_verify($password, $stored_hash);

}

function login($username, $password, $connection)
{

    $query = "SELECT * FROM users WHERE username='$username'";

    $selectResult = $connection->query($query);

    if ($selectResult->num_rows == 1) {
        $result = $selectResult->fetch_assoc();

        if (verify_user_password($result[id], $password, $connection)) {
            return $result[id];
        }
    }
    return 0;
}

function user_exists($username, $connection)
{
    $query = "SELECT * FROM users WHERE username='$username'";

    $selectResult = $connection->query($query);

    if ($selectResult->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}

if (isset($_POST[login])) {
    $login_result = login($username, $password, $connection);
    if ($login_result > 0) {
        session_start();
        $_SESSION[user_id] = $login_result;
        header("Location: index.php");
        die();
    } else {
        echo 'not found';
        // unset post and ask again
    }
}

if (isset($_POST[register])) {
    if (!user_exists($username, $connection)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = "INSERT INTO users VALUES (NULL,'$username','$password_hash','$first_name','$last_name','$email')";

        if ($connection->query($insert_user) === TRUE) {
//            echo "insert success";
        } else {
//            echo "Error: " . $sql . "<br>" . $connection->error;
        }

        $user_id_query = "SELECT id FROM users WHERE username='$username'";
        $result = $connection->query($user_id_query)->fetch_assoc();
        $user_id = $result[id];
        echo $user_id;

        session_start();
        $_SESSION[user_id] = $user_id;
        header("Location: index.php");
        die();
    } else {
        echo 'user name exists, try again';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main Screen</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/loginPage.css">
    <script src="js/javascript.js"></script>
</head>
<body>

<div class="login-page">
    <div class="form">
        <form class="register-form" action="login.php" method="post">
            <input type="text" placeholder="name" name="username"/>
            <input type="password" placeholder="password" name="password"/>
            <input type="text" placeholder="email address" name="email"/>
            <input type="text" placeholder="first name" name="fname"/>
            <input type="text" placeholder="last name" name="lname"/>
            <button type="submit" name="register">create</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
        <form class="login-form" action="login.php" method="post">
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password" name="password"/>
            <button type="submit" name="login">login</button>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
    </div>
</div>

</body>
</html>




