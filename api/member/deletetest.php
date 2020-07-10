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
    $test_q = db_func::db_q("DELETE FROM `test` WHERE `id` IN ({$teststr})");
    $test_q->execute();
    $question_q = db_func::db_q("DELETE FROM `question` WHERE `createTestId` IN ({$teststr})");
    $question_q->execute();
    //刪除成功
    echo json_encode(1);  
?>