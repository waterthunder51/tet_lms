<?php
    date_default_timezone_set("Asia/Taipei");
    // 此系統沒有資料庫
	$sys_id = "tet_lms";
    $config = require 'pdo_config.php';

    function pdo(){
        // 1. 使用 static 變數，讓該變數在函數結束後不會被銷毀
        static $connection = null;
        if ($connection === null) {
            if(!isset($_SESSION)){
                session_start();
            }
            global $sys_id, $config;
            $db_host    = $config["db_host"];
            $db_name    = $config["db_name"];
            $db_charset = $config["db_charset"];
            $db_user    = $config["db_user"];
            $db_pw      = $config["db_pass"];

            try {
                $dsn = "mysql:host={$db_host};dbname={$db_name};charset={$db_charset}";
                $connection = new PDO($dsn, $db_user, $db_pw, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // 建議開啟例外處理
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            }catch(PDOException $e){
                // 建議在生產環境使用 error_log 而非 print_r
                error_log("Database Connection Error: " . $e->getMessage());
                print_r($e->getMessage());
            }
        }
        return $connection;
    }
    
// 接人事資料的DB。
// 注意HR由MSSQL環境改為MySQL。因此，XAMPP要進行一些環境設定。
function pdo_hrdb(){
    if(!isset($_SESSION)){
        session_start();
    }
    global $config;
    // tw074164p => 環安正式區
    $db_host    = $config["hrdb_host"];
    $db_name    = $config["hrdb_name"];
    $db_charset = $config["hrdb_charset"];
    $db_user    = $config["hrdb_user"];
    $db_pw      = $config["hrdb_pass"];
    
    try {
        $dsn = "mysql:host={$db_host};dbname={$db_name};charset={$db_charset}";
        $pdo = new PDO($dsn, $db_user, $db_pw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "hrDB连接成功...";
    }catch(PDOException $e){
        // echo "hrDB資料庫連線失敗: " . $e->getMessage() . "\n嘗試連接到localhost資料庫...";
        try {
               $dsn = "mysql:host=localhost;dbname={$db_name};charset={$db_charset}";
               $pdo = new PDO($dsn, $db_user, $db_pw);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            die("hrDB&localhost连接失败: " . $e->getMessage());
        }
    }

    return $pdo;
}