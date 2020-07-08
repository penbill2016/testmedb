<?php 
    require_once '../../db.php';
      //解決跨域問題
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: *");
      header("Access-Control-Allow-Headers: *");
    //post解析
    $Post = json_decode(file_get_contents('php://input'), true);
    $folderstr = '';
    $isfirst = true;
    foreach($Post['foldersid'] as $value){
        if($isfirst){
            $isfirst = false;
            $folderstr.=$value;
        }else{
            $folderstr.=','.$value;
        }
    }
    $stmt = db_func::db_q("DELETE FROM `folder` WHERE `id` in ({$folderstr})");
    $stmt->execute();
    echo $folderstr;
    
?>