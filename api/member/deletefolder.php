<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    //把folder下的test及question一併刪除
    $folderstr = "";
    $isfirst = true;
    foreach($Post['foldersid'] as $value){
        if($isfirst){
            $isfirst = false;
            $folderstr.="'".$value."'";
        }else{
            $folderstr.=","."'".$value."'";
        }
    }
    //要先取出即將刪除folder的id
    $test_q = db_func::db_q("SELECT * FROM `test` WHERE `createFolderId` IN ({$folderstr})");
    $test_q->execute();
    $test_r = $test_q->fetchAll(PDO::FETCH_CLASS);
    $teststr = '';
    $isfirst = true;
    foreach($test_r as $value){
        if($isfirst){
            $isfirst = false;
            $teststr.="'".$value->id."'";
        }else{
            $teststr.=','."'".$value->id."'";
        }        
    }
    $folder_q = db_func::db_q("DELETE FROM `folder` WHERE `id` IN ({$folderstr})");
    $folder_q->execute();
    $test_q = db_func::db_q("DELETE FROM `test` WHERE `createFolderId` IN ({$folderstr})");
    $test_q->execute();
    $question_q = db_func::db_q("DELETE FROM `question` WHERE `createTestId` IN ({$teststr})");
    $question_q->execute();
    //刪除成功
    echo json_encode(1);    
?>