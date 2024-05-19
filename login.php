<?php
    $conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
    session_start();
    if(isset($_POST['submit'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $accountCheck = "select * from user where email = '$username' and password = '$password'";
        
        $result = mysqli_query($conn, $accountCheck);
        $check = mysqli_num_rows($result);
        if($check == 1) {
            while($row = mysqli_fetch_row($result)) {
                $idAccount = $row[0];
                $fullname = $row[1];
            }
            $fullname = $_SESSION['login']['fullname'];
            $_SESSION['login']['username'] = $username;
            $_SESSION['login']['password'] = $password;
            $_SESSION['login']['idAccount'] = $idAccount;
            header('Location: ./account.php');
        }
        else{
            $error[] = 'incorrect email or password!';
        }
    }
?>


