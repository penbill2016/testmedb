<?php 
    require_once '../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $stmt = db_func::db_q("SELECT * FROM `user` WHERE `account`='{$Post["account"]}' && `password`='{$Post["password"]}'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $flag = 0;

    //API資料結構
    //user
    $userdata = [
        'id' => null,
        'account'  => null,
        'password'  => null,
        'email'  => null,
        'outfolderid' => null,
        'folders'  => [],
        'outtests'  => [],
    ];
    //outfolder
    $folderdata = [
        'id' => null,
        'name'  => null,
        'createdate'  => null,
        'modifydate'  => null,
    ];
    //outtest
    $outtestdata = [
        'id' => null,
        'name'  => null,
        'questions' => null,
        'mode'  => null,
        'correctrate'  => null,
        'createdate'  => null,
        'modifydate'  => null,
    ];
    foreach($result as $value){
        $flag = 1;
        $userdata['id'] = $value->id;
        $userdata['account'] = $value->account;
        $userdata['password'] = $value->password;
        $userdata['email'] = $value->email;
    }
    if($flag==1){
        //folders
        $outfolder_q = db_func::db_q("SELECT * FROM `folder` WHERE `createUserId`='{$userdata['id']}'");
        $outfolder_q->execute();
        $outfolder_r = $outfolder_q->fetchAll(PDO::FETCH_CLASS);
        $outfolderid = null;
        foreach($outfolder_r as $value){
            if($value->isOutFolder){
                $outfolderid = $value->id;
                $userdata['outfolderid'] = $outfolderid;
            }
            else{
                $folderdata['id'] = $value->id; 
                $folderdata['name'] = $value->name;
                $folderdata['createdate'] = $value->createDate;
                $folderdata['modifydate'] = $value->modifyDate;
                array_push($userdata['folders'],$folderdata);
            }
        }
        //outtests
        $outtest_q = db_func::db_q("SELECT * FROM `test` WHERE `createFolderId`='{$outfolderid}'");
        $outtest_q->execute();
        $outtest_r = $outtest_q->fetchAll(PDO::FETCH_CLASS);
        foreach($outtest_r as $value){
            $outtestdata['id'] = $value->id; 
            $outtestdata['name'] = $value->name;
            $outtestdata['questions'] = $value->questions;
            $outtestdata['mode'] = $value->mode;
            $outtestdata['correctrate'] = $value->correctRate;
            $outtestdata['createdate'] = $value->createDate;
            $outtestdata['modifydate'] = $value->modifyDate; 
            array_push($userdata['outtests'],$outtestdata);
        }
        echo json_encode($userdata); 
    }
    else{
        echo json_encode(0);       
    }
?>