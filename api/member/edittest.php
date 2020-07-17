<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $conn = ConnectDB::getConnection();
    
    //先把所有題目刪除
    $ques_q = db_func::db_q("DELETE FROM `question` WHERE `createTestId`=?");
    $ques_q->bindParam(1,$Post["testid"]);
    $ques_q->execute();

    //取得當前url
    $currlink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/'.explode('/', $_SERVER['REQUEST_URI'])[1];
    //先重新覆蓋上新資料
    foreach($Post['questests'] as $value){
        $ques_q = $conn->prepare("INSERT INTO `question`(`createTestId`) VALUES (?)");
        $ques_q->bindParam(1,$Post['testid']);
        $ques_q->execute();
        $quesid = $conn->lastInsertId();
        //question img
        $qtext = $value["quesText"];
        if($value["quesType"]=='text'){
            $q_imgurl = '';
        }
        else{
            $qtext = '';
            if($value['quesImgOri']!=''){
                $q_imgurl = $value['quesImgOri'];
            }
            else{
                $q_save_folder = "../../upload/img/question/";        
                $q_img = $value['quesImg'];//base64
                $q_imgformat='';
                if(strpos($q_img,'image/png')){
                    $q_imgformat = 'png';
                    $q_img = str_replace('data:image/png;base64,', '', $q_img);            
                }
                else if(strpos($q_img,'image/jpeg')){
                    $q_imgformat = 'jpg';
                    $q_img = str_replace('data:image/jpeg;base64,', '', $q_img); 
                }
                $q_img = str_replace(' ', '+', $q_img);
                $q_imgdata = base64_decode($q_img);
                $q_file_name = $quesid.'.'.$q_imgformat;
                $q_imgpath = $q_save_folder.$q_file_name;       
                file_put_contents($q_imgpath, $q_imgdata);
                $q_imgurl = $currlink."/upload/img/question/".$q_file_name;
            }
        }
        //answer img
        $atext = $value["ansText"];
        if($value["ansType"]=='text'){
            $a_imgurl = '';
        }
        else{
            $atext = '';
            if($value['ansImgOri']!=''){
                $a_imgurl = $value['ansImgOri'];
            }
            else{
                $a_save_folder = "../../upload/img/answer/";
                $a_img = $value['ansImg'];//base64
                $a_imgformat='';
                if(strpos($a_img,'image/png')){
                    $a_imgformat = 'png';
                    $a_img = str_replace('data:image/png;base64,', '', $a_img);            
                }
                else if(strpos($a_img,'image/jpeg')){
                    $a_imgformat = 'jpg';
                    $a_img = str_replace('data:image/jpeg;base64,', '', $a_img); 
                }
                $a_img = str_replace(' ', '+', $a_img);
                $a_imgdata = base64_decode($a_img);
                $a_file_name = $quesid.'.'.$a_imgformat;
                $a_imgpath = $a_save_folder.$a_file_name;
                file_put_contents($a_imgpath, $a_imgdata);
                $a_imgurl = $currlink."/upload/img/answer/".$a_file_name;
            }
        }
        $ques_q = db_func::db_q("UPDATE `question` SET `quesType`=?,`quesImg`=?,`ansType`=?,`ansImg`=?,`quesText`=?,`ansText`=? WHERE `id`=?");
        $ques_q->bindParam(1,$value["quesType"]);
        $ques_q->bindParam(2,$q_imgurl);
        $ques_q->bindParam(3,$value["ansType"]);
        $ques_q->bindParam(4,$a_imgurl);
        $ques_q->bindParam(5,$qtext);
        $ques_q->bindParam(6,$atext);
        $ques_q->bindParam(7,$quesid);
        $ques_q->execute();
    }
    //更新test title
    $quesCounts = count($Post['questests']);
    $date = func::get_nowdate();
    $mode = 0;
    switch($Post['mode']){
        case "0":
            $mode = 0;
            break;
        case "1":
            $mode = 1;
            break;
    }
    $test_q = db_func::db_q("UPDATE `test` SET `name`=?,`questions`=?,`mode`=?,`modifyDate`=? WHERE `id`=?");
    $test_q->bindParam(1,$Post['testtitle']);
    $test_q->bindParam(2,$quesCounts);
    $test_q->bindParam(3,$mode);
    $test_q->bindParam(4,$date);
    $test_q->bindParam(5,$Post['testid']);
    $test_q->execute();
    //編輯成功
    echo json_encode(1);
?>