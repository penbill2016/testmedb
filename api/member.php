<?php 
    require_once '../db.php';
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $stmt = db_func::db_q("SELECT * FROM `user` WHERE `account`=? && `password`=?");
    $stmt->bindParam(1,$Post["account"]);
    $stmt->bindParam(2,$Post["password"]);
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
    $folderorderby = '';
    $folderorder = '';
    switch($Post["folderorderby"]){
        case "Created":
            $folderorderby = "createDate";
        break;
        case "Modified":
            $folderorderby = "modifyDate";
        break;
    }
    if($Post["folderasc"]){
        $folderorder = "ASC";
    }
    else{
        $folderorder = "DESC";
    }

    $testorderby = '';    
    $testorder = '';
    switch($Post["testorderby"]){
        case "Created":
            $testorderby = "createDate";
            break;
        case "Modified":
            $testorderby = "modifyDate";
            break;
        case "Correctrate":
            $testorderby = "correctRate";
            break;
    }
    if($Post["testasc"]){
        $testorder = "ASC";
    }
    else{
        $testorder = "DESC";
    }

    if($flag==1){
        //folders
        $outfolder_q = db_func::db_q("SELECT * FROM `folder` WHERE `createUserId`='{$userdata['id']}' ORDER BY `{$folderorderby}` {$folderorder}");
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
        $outtest_q = db_func::db_q("SELECT * FROM `test` WHERE `createFolderId`='{$outfolderid}' ORDER BY `{$testorderby}` {$testorder}");
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