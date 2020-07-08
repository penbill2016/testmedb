<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $stmt = db_func::db_q("INSERT INTO `folder`(`name`, `createDate`, `modifyDate`, `createUserId`) VALUES ('{$Post["foldername"]}','123','123','{$Post["userid"]}')");
    $stmt->execute();
    //新增成功
    echo json_encode(1);
?>