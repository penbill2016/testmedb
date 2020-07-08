<?php 
    require_once '../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $stmt = db_func::db_q("SELECT * FROM `user` WHERE `account`='{$Post["account"]}' && `password`='{$Post["password"]}'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $flag = 0;//0帳號不存在，1存在
    foreach($result as $value){
        if($value->account!=""){
            $flag = 1;
        }
    }
    if($flag==1){
        //echo '登入';
        echo json_encode(1);
    }
    else{
        //echo '帳號或密碼錯誤'; 
        echo json_encode(0);
    }
?>