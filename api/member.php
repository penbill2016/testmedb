<?php 
    require_once '../db.php';
    //post解析
    $_POST = json_decode(array_keys($_POST)[0], true);
    $stmt = db_func::db_q("SELECT * FROM `user` WHERE `account`='{$_POST["account"]}' && `password`='{$_POST["password"]}'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $userid = -1;
    $flag = 0;
    $userdata = array();
    $userdata['folder'] = array();
    $userdata['test'] = array();
    foreach($result as $value){
        if($value->account!=""){
            $flag = 1;
            $userid = $value->id;
        }
    }
    if($flag==1){
        $folder_q = db_func::db_q("SELECT * FROM `folder` WHERE `createUserId`='{$userid}' && `isOutFolder`=0");
        $folder_q->execute();
        $folder_r = $folder_q->fetchAll(PDO::FETCH_CLASS);
        $folder_data = array();
        foreach($folder_r as $value){
            array_push($folder_data['name'],$value->name); 
            // array_push($folder_data['createDate'],$value->createDate); 
            // array_push($folder_data['modifyDate'],$value->modifyDate); 
        }
        array_push($userdata['folder'],$folder_data);
        echo json_encode($userdata); 
    }
    else{
        echo json_encode(0); 
       
    }
?>