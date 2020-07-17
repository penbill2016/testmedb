<?php 
    require_once '../../db.php';    
    $stmt = db_func::db_q("SELECT * FROM `question` WHERE `createTestId`=?");
    $stmt->bindParam(1,$_GET['testid']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $questions = array();
    $questiondata = [
        'id' => null,
        'quesType'  => null,
        'quesText'  => null,
        'quesImg'  => null,
        'ansType'  => null,
        'ansText'  => null,
        'ansImg'  => null,
    ];
    foreach($result as $value){
        $questiondata['id'] = $value->id; 
        $questiondata['quesType'] = $value->quesType; 
        $questiondata['quesText'] = $value->quesText; 
        $questiondata['quesImg'] = $value->quesImg; 
        $questiondata['ansType'] = $value->ansType; 
        $questiondata['ansText'] = $value->ansText; 
        $questiondata['ansImg'] = $value->ansImg; 
        array_push($questions,$questiondata);
    }
    echo json_encode($questions);
?>