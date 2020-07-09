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
    $stmt = db_func::db_q("DELETE FROM `test` WHERE `id` in ({$teststr})");
    $stmt->execute();
    echo $teststr;    
?>