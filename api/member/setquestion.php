<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $stmt = db_func::db_q("UPDATE `test` SET `correctRate`='{$Post['correctrate']}' WHERE `id`='{$Post['testid']}'");
    $stmt->execute();
   
    echo json_encode(1);
?>