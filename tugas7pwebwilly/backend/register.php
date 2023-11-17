<?php

require './../config/db.php';
// membuat session
session_start();

if(isset($_POST['submit'])) {

    global $db_connect;

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if($confirm != $password) {
        echo "password tidak sesuai dengan konfirmasi password";
        die;
    }

    $usedEmail = mysqli_query($db_connect,"SELECT email FROM user WHERE email = '$email'");
    if(mysqli_num_rows($usedEmail) > 0) {
        echo "email sudah digunakan";
        die;
    }

    $password = password_hash($password,PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s',time());
        
    $users = mysqli_query($db_connect,"INSERT INTO user (name,email, password,created_at) VALUES
                            ('$name','$email','$password','$created_at')");

    $getUserdata = mysqli_query($db_connect, " SELECT name, role FROM user WHERE email = '$email' ");
    $sessionData = mysqli_fetch_assoc($getUserdata);
    $_SESSION['name'] =  $sessionData['name'];
    $_SESSION['role'] = $sessionData ['role'];

    header("Location: ./../profile.php");
    // print_r($_SESSION['role']);
    // print_r (mysqli_fetch_assoc($getUserdata));
    // $_SESSION['name'] =  $name;
    // // $_SESSION['role'];
    // echo "registrasi berhasil";
}
