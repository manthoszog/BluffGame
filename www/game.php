<?php
    require_once "../lib/dbconnect.php";

    $method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$input = json_decode(file_get_contents('php://input'),true);

    if($input==null) {
        $input=[];
    }
    else if(isset($_SERVER['HTTP_X_TOKEN'])) {
        $input['token'] = $_SERVER['HTTP_X_TOKEN'];
    } 
    else {
        $st23 = $mysqli->prepare('select player_turn from game_status');
        $st23->execute();
        $res23 = $st23->get_result();
        $turn = $res23->fetch_assoc();
        
        $st24 = $mysqli->prepare('select token from user where onoma=?');
        $st24->bind_param('s',$turn['player_turn']);
        $st24->execute();
        $res24 = $st24->get_result();
        $t2 = $res24->fetch_assoc();
        $input['token'] = $t2['token'];
    }

    switch($req=array_shift($request)){
        case 'cards':
            switch($req3=array_shift($request)){
                case '':
                case null:
                    if($method == 'GET'){
                        header('Content-type: application/json');
                        print json_encode(['Message'=>"Player 1 Cards:"]);
                        $statement = $mysqli->prepare('select * from player1_karta');
                        $statement->execute();
                        $result = $statement->get_result();
                        header('Content-type: application/json');
                        print json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

                        //header('Content-type: application/json');
                        print json_encode(['Message'=>"Player 2 Cards:"]);
                        $st2 = $mysqli->prepare('select * from player2_karta');
                        $st2->execute();
                        $result2 = $st2->get_result();
                        //header('Content-type: application/json');
                        print json_encode($result2->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

                        //header('Content-type: application/json');
                        print json_encode(['Message'=>"Cards on table:"]);
                        $st3 = $mysqli->prepare('select * from stoiva_karta');
                        $st3->execute();
                        $result3 = $st3->get_result();
                        //header('Content-type: application/json');
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
                case 'play':
                    if($method == 'PUT') {
                        if($input['token'] == null || $input['token'] == '') {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"Token is not set."]);
                            exit;
                        }
                        
                        $name = null;
                        $st13 = $mysqli->prepare('select * from user where token=?');
                        $st13->bind_param('s',$input['token']);
                        $st13->execute();
                        $res13 = $st13->get_result();
                        if($row=$res13->fetch_assoc()) {
                            $name = $row['onoma'];
                        }

                        if($name == null ) {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"You are not a player of this game."]);
                            exit;
                        }
                        
                        $st14 = $mysqli->prepare('select * from game_status');
                        $st14->execute();
                        $res14 = $st14->get_result();
                        $status2 = $res14->fetch_assoc();

                        if($status2['status']!='started') {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"Game is not in action."]);
                            exit;
                        }
                        if($status2['player_turn']!=$name) {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"It is not your turn."]);
                            exit;
                        }


                        //move cards

                        $name_sql = "$name" . '_karta';
                        $st15 = $mysqli->prepare("select * from $name_sql where id=?");
                        $st15->bind_param('i',$input['id1']);
                        $st15->execute();
                        $res15 = $st15->get_result();
                        $row2 = $res15->fetch_assoc();
                        
                        $st16 = $mysqli->prepare('insert into stoiva_karta(id,arithmos,xroma,symvolo) values(?,?,?,?)');
                        $st16->bind_param('isss',$row2['id'],$row2['arithmos'],$row2['xroma'],$row2['symvolo']);
                        $st16->execute();

                        $st19 = $mysqli->prepare("select * from $name_sql where id=?");
                        $st19->bind_param('i',$input['id2']);
                        $st19->execute();
                        $res19 = $st19->get_result();
                        $row3 = $res19->fetch_assoc();
                        
                        $st20 = $mysqli->prepare('insert into stoiva_karta(id,arithmos,xroma,symvolo) values(?,?,?,?)');
                        $st20->bind_param('isss',$row3['id'],$row3['arithmos'],$row3['xroma'],$row3['symvolo']);
                        $st20->execute();

                        $st27 = $mysqli->prepare("select arithmos,xroma,symvolo from $name_sql where id=? or id=?");
                        $st27->bind_param('ii',$input['id1_bluff'],$input['id2_bluff']);
                        $st27->execute();
                        $res27 = $st27->get_result();
                        $bluff_cards = $res27->fetch_assoc();
                        
                        $st17 = $mysqli->prepare("delete from $name_sql where id in (select id from stoiva_karta)");
                        $st17->execute();

                        header('Content-type: application/json');
                        print json_encode(['Message'=>"$name played cards: $bluff_cards"]);
                        print json_encode(['Message'=>"Opponent: Bluff, yes or no?"]);

                        $st28 = $mysqli->prepare('insert into bluff_table(id1,id2,id1_bluff,id2_bluff) values(?,?,?,?)');
                        $st28->bind_param('iiii',$input['id1'],$input['id2'],$input['id1_bluff'],$input['id2_bluff']);
                        $st28->execute();

                        //move ends

                        //update player turn
                        if($name == 'player1'){
                            $name = 'player2';
                            $st18 = $mysqli->prepare('update game_status set player_turn=?');
                            $st18->bind_param('s',$name);
                            $st18->execute();
                        }
                        else if($name == 'player2'){
                            $name = 'player1';
                            $st18 = $mysqli->prepare('update game_status set player_turn=?');
                            $st18->bind_param('s',$name);
                            $st18->execute();
                        }
                        //update ends

                        //check if game ended

                        $st21 = $mysqli->query('select count(*) as c from player1_karta');
                        $res21 = $st21->get_result();
                        $p1count = $res21->fetch_assoc();

                        $st22 = $mysqli->query('select count(*) as c from player2_karta');
                        $res22 = $st22->get_result();
                        $p2count = $res22->fetch_assoc();

                        if($p1count['c'] == 0){
                            $mysqli->query("update game_status set status='ended',player_turn=null,result='player1'");
                            header('Content-type: application/json');
                            print json_encode(['Message'=>"Winner: Player1"]);
                            exit;
                        }
                        
                        if($p2count['c'] == 0){
                            $mysqli->query("update game_status set status='ended',player_turn=null,result='player2'");
                            header('Content-type: application/json');
                            print json_encode(['Message'=>"Winner: Player2"]);
                            exit;
                        }

                        //check ends
                    }
                    else{
                        header('HTTP/1.1 405 Method Not Allowed'); 
                    }
                    break;
                case 'bluff':
                    if($method == 'PUT') {
                        $answer = json_decode(file_get_contents('php://input'),true);

                        if($input['token'] == null || $input['token'] == '') {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"Token is not set."]);
                            exit;
                        }

                        $name2 = null;
                        $st25 = $mysqli->prepare('select * from user where token=?');
                        $st25->bind_param('s',$input['token']);
                        $st25->execute();
                        $res25 = $st25->get_result();
                        if($row4=$res25->fetch_assoc()) {
                            $name2 = $row4['onoma'];
                        }

                        if($name2 == null ) {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"You are not a player of this game."]);
                            exit;
                        }
                        
                        $st26 = $mysqli->prepare('select * from game_status');
                        $st26->execute();
                        $res26 = $st26->get_result();
                        $status3 = $res26->fetch_assoc();

                        if($status3['status']!='started') {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"Game is not in action."]);
                            exit;
                        }
                        if($status3['player_turn']!=$name2) {
                            header("HTTP/1.1 400 Bad Request");
                            print json_encode(['errormesg'=>"It is not your turn."]);
                            exit;
                        }
                        
                        switch($answer['bluff']){
                            case 'yes':
                                $st29 = $mysqli->query('select * from bluff_table');
                                $res29 = $st29->get_result();
                                $tableb = $res29->fetch_assoc();
                                if(($tableb['id1'] == $tableb['id1_bluff']) &&  ($tableb['id2'] == $tableb['id2_bluff'])){
                                    if($name2 == 'player1'){
                                        $name2 = 'player2';
                                    }
                                    else if($name2 == 'player2'){
                                        $name2 = 'player1';
                                    }
                                    $name2_sql = "$name2" . '_win()';
                                    $mysqli->query("call $name2_sql");

                                    $mysqli->query('delete from bluff_table');
                                    /* to paixnidi synexizetai, 
                                    o idios paiktis prepei tora 
                                    na rixei xartia me to PUT /cards/play
                                    */
                                }
                                else{
                                    switch($name2){
                                        case 'player1':
                                            $mysqli->query('call player1_win()');
                                            break;
                                        case 'player2':
                                            $mysqli->query('call player2_win()');
                                            break;
                                    }
                                    /* to paixnidi synexizetai, 
                                    o idios paiktis prepei tora 
                                    na rixei xartia me to PUT /cards/play
                                    */
                                }
                                break;
                            case 'no':
                                /* to paixnidi synexizetai, 
                                o idios paiktis prepei tora 
                                na rixei xartia me to PUT /cards/play
                                */
                                exit;
                            default:
                                header("HTTP/1.1 400 Bad Request");
                                print json_encode(['errormesg'=>"Wrong answer"]);
                                exit;
                        }
                    }
                    else{
                        header('HTTP/1.1 405 Method Not Allowed'); 
                    }
                    break;
                default: 
                    header("HTTP/1.1 404 Not Found");
                    break;
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
                    $st6->bind_param('ss',$username,$username);
                    $st6->execute();
                
                    $st8 = $mysqli->prepare('select * from game_status');
                    $st8->execute();
                    $res8 = $st8->get_result();
                    $status = $res8->fetch_assoc();
                    
                    
                    $new_status=null;
                    $new_turn=null;
                    
                    $st9=$mysqli->prepare('select count(*) as aborted from user where last_action < (NOW() - INTERVAL 5 MINUTE)');
                    $st9->execute();
                    $res9 = $st9->get_result();
                    $aborted = $res9->fetch_assoc()['aborted'];
                    if($aborted > 0) {
                        $st10 = $mysqli->prepare('delete from user where last_action < (NOW() - INTERVAL 5 MINUTE)');
                        $st10->execute();
                        if($status['status']=='started') {
                            $new_status='aborted';
                        }
                    }

                    $st11 = $mysqli->prepare('select count(*) as c from user');
                    $st11->execute();
                    $res11 = $st11->get_result();
                    $active_players = $res11->fetch_assoc()['c'];

                    switch($active_players) {
                        case 0: 
                            $new_status='not active'; 
                            break;
                        case 1: 
                            $new_status='initialized'; 
                            break;
                        case 2: 
                            $new_status='started'; 
                            if($status['player_turn']==null) {
                                $new_turn='player1';
                            }
                            break;
                    }

                    $st12 = $mysqli->prepare('update game_status set status=?, player_turn=?');
                    $st12->bind_param('ss',$new_status,$new_turn);
                    $st12->execute();

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