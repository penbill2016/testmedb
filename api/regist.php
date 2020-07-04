<?php 
    require_once '../db.php';
    $conn = ConnectDB::getConnection();
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `account`='{$_POST["account"]}'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $flag = 0;//0帳號不存在，1存在
    foreach($result as $value){
        if($value->account!=""){
            $flag = 1;
        }
    }
    if($flag==1){
        //echo '已有登入帳號';
        echo json_encode(0);
    }
    else{
        $insert = $conn->prepare("INSERT INTO `user`(`account`, `password`, `email`) VALUES ('{$_POST["account"]}','{$_POST["password"]}','{$_POST["email"]}')");
        $insert->execute();
        //echo '註冊成功';
        echo json_encode(1);
    }
?>