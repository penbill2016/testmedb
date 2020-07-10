<?php 
    session_start();
    class ConnectDB{
        static $conn = NULL;
        function getConnection(){
            $serverName = "localhost";
            
            //local
            $databaseName = "testme";
            $dbuser = "popo";

            //godady
            //$databaseName = "dbtestme";
            //$dbuser = "penbillpopo";

            $dbpassword = "075717169";
            //解決跨域問題
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: *");
            header("Access-Control-Allow-Headers: *");
            //時區設定
            date_default_timezone_set("Asia/Taipei");
            //資料庫連線
            if(!isset($conn)){
                try{
                    $conn = new PDO("mysql:host=$serverName; dbname=$databaseName;",$dbuser,$dbpassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $conn->exec("set names utf8");
                }
                catch(Exception $e){
                    echo $e->getMessage();
                    error_log($e->getMessage(),0);
                }
            }
            return $conn;
        }      
    }
    class db_func extends ConnectDB{
        function db_q($query=''){
            $conn = parent::getConnection();
            $stmt = $conn->prepare($query);
            return $stmt;
        }
        function setlogincheck($account,$password){
            $_SESSION['db']['account'] = $account;
            $_SESSION['db']['password'] = $password;
        }
        function unsetlogincheck(){
            unset($_SESSION['db']['account']);
            unset($_SESSION['db']['password']);
        }
        function checklogin(){
            $conn = parent::getConnection();
            if(isset($_SESSION['db']['account']) && isset($_SESSION["db"]["password"])){
                $stmt = $conn->prepare("SELECT * FROM `user` WHERE `account`='{$_SESSION["db"]["account"]}' && `password`='{$_SESSION["db"]["password"]}'");
                $stmt->execute();
                $rowcount = $stmt->rowCount();
                if($rowcount>0){
                    return true;
                }
                else{
                    return false;
                }                             
            }
            else{
                return false;
            }
        }
        function db_rowsize($input){
            $result=self::db_q($input);
            $result->execute();
            $data=$result->rowcount();
            return $data;
        }       
    }
    class func {
        function r_size($input){
            $result=$input->rowcount();
            return $result;
        }
        function get_nowdate(){            
            return date('Y-m-d H:i:s');
        }
    }
?>