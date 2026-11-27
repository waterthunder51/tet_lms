<?php
// 以下為接收ajax並回拋結果
// 導入資料庫
require_once("../pdo.php");
// 假設您的 $_POST['action'] 傳遞的是廠區的 ID
$areaId = $_POST['action'];
// echo $areaId."<br>";
if($areaId == 0 ){
    $fabWithareas = allFab();
}else{
    // 使用您的 fabChangLocal 函數來獲取相應的數據
    $fabWithareas = areaChangFab($areaId);
}

// echo print_r($localWithFabs);
// for 觸發互動式窗按鈕edit頁面使用。
// 導入JSon的系統語言，利於回傳使用
header('Content-Type: application/json; charset=utf-8');

function areaChangFab($data){
    $pdo = pdo();
    $sql = "SELECT _fab.* , 
            _site.id AS s_id, _site.site_title,
            _area.id AS a_id, _area.area_title
            FROM _fab
            LEFT JOIN _site ON _fab.site_id = _site.id
            LEFT JOIN _area ON _fab.area_id = _area.id
            WHERE _fab.area_id = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$data]);
        $post = $stmt->fetchAll();
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
function allFab(){
    $pdo = pdo();
    $sql = "SELECT * FROM _fab";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $post = $stmt->fetchAll();
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

echo json_encode($fabWithareas);
exit();
