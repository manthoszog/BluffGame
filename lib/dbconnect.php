<?php
    $host='localhost';
    $db = 'gamedb';
    require_once "db_upass.php";

    $user=$DB_USER;
    $pass=$DB_PASS;
    $user2=$DB_USER2;


    if(gethostname()=='users.iee.ihu.gr') {
        $mysqli = new mysqli($host, $user2, $pass, $db,null,'/home/student/it/2018/it185179/mysql/run/mysql.sock');
    } 
    else {
        $pass=null;
        $mysqli = new mysqli($host, $user, $pass, $db);
    }

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . 
        $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
?>