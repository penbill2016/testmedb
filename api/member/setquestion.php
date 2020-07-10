<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $date = func::get_nowdate();
    $stmt = db_func::db_q("UPDATE `test` SET `correctRate`='{$Post['correctrate']}',`modifyDate`='{$date}' WHERE `id`='{$Post['testid']}'");
    $stmt->execute();
    //更新成功
    echo json_encode(1);
?>