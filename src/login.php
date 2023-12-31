<?php
//Connection
$conn = new mysqli('sql11.freemysqlhosting.net', 'sql11669919', 'kgzx5LEnIr', 'sql11669919');

if ($conn->connect_error)
{
    die('Connection Failed : '. $conn->connect_error);
}

session_start();

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    //Gets user credentials from DB
    $query = "SELECT * FROM users WHERE email = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) 
    {
        $user = $result->fetch_assoc();

        $verified = $user['verified'];

        //Store the IBAN in a session variable
        $_SESSION['user_iban'] = $user['iban'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_bal'] = $user['bal'];
        $_SESSION['user_verified'] = $user['user_verified'];
  
        if ($verified == 0)
        {
        header("Location: ../src/Logged.php");
        }
        else if ($verified == 1)
        {
        //Redirect to a page where you are logged in and verified
        header("Location: ../src/Logged_verified.php");
        }
    }
     else 
    {
        readfile("../pages/login/login_fail.html");
    }

    $stmt->close();
?>