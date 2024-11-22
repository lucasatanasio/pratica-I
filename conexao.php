<?php

$conn = mysqli_connect("localhost", "root", "root", "empresa");

if(!$conn){
    die("Connection failed." . mysqli_connect_error());
}

?>