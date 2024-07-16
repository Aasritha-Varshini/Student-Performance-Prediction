<?php
include "connection.php";
session_unset();
session_destroy();
header('location:main/index.php');
?>