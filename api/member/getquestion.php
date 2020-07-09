<?php 
    require_once '../../db.php';    
    $stmt = db_func::db_q("SELECT * FROM `question` WHERE `createTestId`='{$_GET['testid']}'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $questions = array();
    $questiondata = [
        'id' => null,
        'question'  => null,
        'answer'  => null,
    ];
    foreach($result as $value){
        $questiondata['id'] = $value->id; 
        $questiondata['question'] = $value->question; 
        $questiondata['answer'] = $value->answer; 
        array_push($questions,$questiondata);
    }
    echo json_encode($questions);
?>