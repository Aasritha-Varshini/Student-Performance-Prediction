<?php
require('connection.php');
session_start();

if (isset($_POST['loginbtn'])) {
    $uname = $_POST['user'];
    $pwd = md5($_POST['pwd']);

    $studentQuery = "SELECT roll_no, sname, branch FROM student WHERE roll_no = '$uname' AND password = '$pwd'";
    $studentResult = mysqli_query($con, $studentQuery);

    if (mysqli_num_rows($studentResult) == 1) {
        $studentRow = mysqli_fetch_row($studentResult);
        $_SESSION['roll_no'] = $studentRow[0];
        $_SESSION['sname'] = $studentRow[1];
        $_SESSION['branch'] = $studentRow[2];
        header("Location: ui/student.php");
        exit();
    } else {
        header("Location: index.php?err=1");
        exit();
    }
}
?>
