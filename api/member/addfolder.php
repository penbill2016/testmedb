<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $date = func::get_nowdate();
    $stmt = db_func::db_q("INSERT INTO `folder`(`name`, `createDate`, `modifyDate`, `createUserId`) VALUES (?,?,?,?)");
    $stmt->bindParam(1,$Post["foldername"]);
    $stmt->bindParam(2,$date);
    $stmt->bindParam(3,$date);
    $stmt->bindParam(4,$Post["userid"]);
    $stmt->execute();
    //新增成功
    echo json_encode(1);
?>