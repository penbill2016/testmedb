<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $teststr = '';
    $isfirst = true;
    foreach($Post['testsid'] as $value){
        if($isfirst){
            $isfirst = false;
            $teststr.=$value;
        }else{
            $teststr.=','.$value;
        }
    }
    $date = func::get_nowdate();
    $stmt = db_func::db_q("UPDATE `test` SET `createFolderId`=?,`modifyDate`=? WHERE `id` IN ({$teststr})");
    $stmt->bindParam(1,$Post['folderid']);
    $stmt->bindParam(2,$date);
    $stmt->execute();
    //更新成功
    echo json_encode(1);
?>