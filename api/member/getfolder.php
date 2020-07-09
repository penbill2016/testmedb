<?php 
    require_once '../../db.php';
    //API資料結構   
    $tests = array();
    //outtest
    $testdata = [
        'id' => null,
        'name'  => null,
        'questions' => null,
        'mode'  => null,
        'correctrate'  => null,
        'createdate'  => null,
        'modifydate'  => null,
    ];
    //outtests
    $test_q = db_func::db_q("SELECT * FROM `test` WHERE `createFolderId`='{$_GET["folderid"]}'");
    $test_q->execute();
    $test_r = $test_q->fetchAll(PDO::FETCH_CLASS);
    foreach($test_r as $value){
        $testdata['id'] = $value->id; 
        $testdata['name'] = $value->name;
        $testdata['questions'] = $value->questions;
        $testdata['mode'] = $value->mode;
        $testdata['correctrate'] = $value->correctRate;
        $testdata['createdate'] = $value->createDate;
        $testdata['modifydate'] = $value->modifyDate; 
        array_push($tests,$testdata);
    }
    echo json_encode($tests);
?>