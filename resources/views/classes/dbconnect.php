<?php
require_once './classes/env.php';
function connect(){
    #    $host = DB_HOST;
    #    $db   = DB_NAME;
    #    $user = DB_USER;
    #    $pass = DB_PASS;
    $host = 'localhost';
    $db   = 'blog';
    $user = 'root';
    $pass = '';


    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $dbh=new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 
 #       echo '成功です！';
        return $dbh;
    } catch(PDOExcption $e){
        echo '接続失敗！' . $e->getMessage();
        exit();
    }
}

#connect();

?>