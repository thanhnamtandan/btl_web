<?php
    session_start();
    unset($_SESSION['login']['username']);
    header('location: ./home.php');
?>