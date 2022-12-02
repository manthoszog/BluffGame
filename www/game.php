<?php
    require_once "../lib/dbconnect.php";

    $method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$input = json_decode(file_get_contents('php://input'),true);

    switch($req=array_shift($request)){
        case 'cards':
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
            $req2=array_shift($request);
            if($method =='PUT'){
                if(!isset($req2) || $req2 == '') {
                    header("HTTP/1.1 400 Bad Request");
                    print json_encode(['errormesg'=>"No username given."]);
                    exit;
                }
                
                if(($req2 == 'player1') || ($req2 == 'player2')){

                    $username = $req2;

                    $st5 = $mysqli->prepare('select count(*) as c from user where onoma=?');
                    $st5->bind_param('s',$username);
                    $st5->execute();
                    $res5 = $st5->get_result();
                    $r5 = $res5->fetch_all(MYSQLI_ASSOC);
                    if($r5[0]['c']>0) {
                        header("HTTP/1.1 400 Bad Request");
                        print json_encode(['errormesg'=>"Player $username is already set. Please select another color."]);
                        exit;
                    }
                
                    $st6 = $mysqli->prepare('insert into user(onoma, token) values(?, md5(CONCAT( ?, NOW())))');
                    $st6->bind_param('sss',$username,$username);
                    $st6->execute();
                
                    //update game status

                    $st7 = $mysqli->prepare('select * from user where onoma=?');
                    $st7->bind_param('s',$username);
                    $st7->execute();
                    $res7 = $st7->get_result();
                    header('Content-type: application/json');
                    print json_encode($res7->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
                }
                else{
                    header("HTTP/1.1 400 Bad Request");
                    print json_encode(['errormesg'=>"Select player1 or player2."]);
                    exit;
                }
            }
            else{
                header('HTTP/1.1 405 Method Not Allowed');
            }
            break;
        default: 
            header("HTTP/1.1 404 Not Found");
            exit;
    }
?>