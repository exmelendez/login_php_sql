<?php
$dBServername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "loginsystemtut";

//Create connection
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

//Check connection
if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}