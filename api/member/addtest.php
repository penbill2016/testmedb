<?php 
    require_once '../../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $quesCounts = count($Post['questests']);

    $conn = ConnectDB::getConnection();
    $test_q = $conn->prepare("INSERT INTO `test`(`name`, `questions`, `mode`, `correctRate`, `createDate`, `modifyDate`, `createFolderId`) VALUES ('{$Post["testtitle"]}','{$quesCounts}','0','0','0','0','{$Post["folderid"]}')");
    $test_q->execute();
    $testid = $conn->lastInsertId();
    foreach($Post['questests'] as $value){
        $ques_q = db_func::db_q("INSERT INTO `question`(`question`, `answer`, `createTestId`) VALUES ('{$value["quesText"]}','{$value["ansText"]}','{$testid}')");
        $ques_q->execute();
    }
    //新增成功
    echo json_encode(1);
?>