<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    
    //先把所有題目刪除
    $ques_q = db_func::db_q("DELETE FROM `question` WHERE `createTestId`='{$Post["testid"]}'");
    $ques_q->execute();
  
    //先把重新覆蓋上新資料
    foreach($Post['questests'] as $value){
        $ques_q = db_func::db_q("INSERT INTO `question`(`question`, `answer`, `createTestId`) VALUES ('{$value["quesText"]}','{$value["ansText"]}','{$Post['testid']}')");
        $ques_q->execute();
    }
    //更新test title
    $quesCounts = count($Post['questests']);
    $test_q = db_func::db_q("UPDATE `test` SET `name`='{$Post['testtitle']}',`questions`='{$quesCounts}' WHERE `id`='{$Post['testid']}'");
    $test_q->execute();
    //新增成功
    echo json_encode(1);
?>