<?php
    require_once "../lib/dbconnect.php";

    $method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$input = json_decode(file_get_contents('php://input'),true);

    switch($req=array_shift($request)){
        case 'cards':
            switch($req2=array_shift($request)){
                case '':
                case null:
                    if($method == 'GET'){
                        $mysqli;
                        $query = 'select * from player1_karta';
                    }
                    break;
            }
            break;
        default: 
            header("HTTP/1.1 404 Not Found");
            exit;
    }
?>