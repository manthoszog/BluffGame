<?php
    require_once "../lib/dbconnect.php";

    $method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$input = json_decode(file_get_contents('php://input'),true);

    switch($req=array_shift($request)){
        case 'cards':
            //switch($req2=array_shift($request)){
                //case '':
                //case null:
                    if($method == 'GET'){
                        echo "Player 1 Cards: \n";
                        $statement = $mysqli->prepare('select * from player1_karta');
                        $statement->execute();
                        $result = $statement->get_result();
                        header('Content-type: application/json');
                        print json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

                        echo "Player 2 Cards: \n";
                        $st2 = $mysqli->prepare('select * from player2_karta');
                        $st2->execute();
                        $result2 = $st2->get_result();
                        header('Content-type: application/json');
                        print json_encode($result2->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

                        echo "Cards on table: \n";
                        $st3 = $mysqli->prepare('select * from stoiva_karta');
                        $st3->execute();
                        $result3 = $st3->get_result();
                        header('Content-type: application/json');
                        print json_encode($result3->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
                    }
                    else if($method == 'POST') {
                        $mysqli->query('call clean_karta()');
                    }
                    else if($method == 'PUT'){
                        $mysqli->query('call moirasma_kartas()');
                    }
                    else{
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                    //break;
            //}
            break;
        case 'status': 
            if(sizeof($request) == 0){
                if($method == 'GET'){
                    $st4 = $mysqli->prepare('select * from game_status');
                    $st4->execute();
                    $res4 = $st4->get_result();
                    header('Content-type: application/json');
		            print json_encode($res4->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
                }
                else{
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            else{
                header("HTTP/1.1 404 Not Found");
            }
            break;
        case 'players':
            
            break;
        default: 
            header("HTTP/1.1 404 Not Found");
            exit;
    }
?>