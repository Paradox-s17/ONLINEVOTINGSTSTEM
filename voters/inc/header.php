<?php
    session_start();
    require_once("../admin/inc/config.php");

    if($_SESSION['key'] != "VotersKey")
    {
        echo "<script> location.assign(
        '../admin/inc/logout.php')</script>";
        die;

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voters-Panel - Online Voting System</title>
    <link rel="stylesheet" href="../assets/css/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
   
    <div class="container-fluid">
        <div class="row text-white bg-black">
            <div class="col-1">
            <img src="../assets/images/logo.jpeg" width="80px"  />
            </div>
            <div class="col-11 my-auto">
                <h3> ONLINE VOTING SYSTEM - <small> welcome <?php echo $_SESSION['username'];?> !</small></h3>
            </div>
        </div>
    </div>