<?php
// 以下為EXCEL檔案上傳
 // 引入PhpSpreadsheet库
require '../vendor/autoload.php';
require_once("../pdo.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

// 設定一個函式，將EXCEL內容進行解包輸出
function processDataFile($fileKey){
    // 先預設一個空陣列，後續回傳使用
    $reData = [];
    // 將POST檔案資料，進行變數命名
    $file = $_FILES[$fileKey]['tmp_name'];
    // 以下為固定使用的"PhpSpreadsheet"
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    // 將資料依序展開
    foreach ($data as $rowIndex => $row) {
        // 跳过表頭
        if ($rowIndex == 0) {
            continue;
        }
        // 如果"row"為空，則跳下一個
        if (empty($row)) {
            continue;
        }
        // 設定一個變數，為"true"
        $isEmptyRow = true;
        // 繞行所有的row內值
        foreach ($row as $column) {
            // 如果非空白，則設定為"false"並打破循環
            if (!empty($column)) {
                $isEmptyRow = false;
                break;
            }
        }
        // 如果"isEmptyRow"為"true"
        if ($isEmptyRow) {
            // 跳过空白列
            continue;
        }
        $owner = showEmpId($row[6]);
        // 以下為三元判定轉換，各別為，是否掛證、掛證棟、掛證廠別、掛證部門
        $licenceNumberCode = empty($row[19])? '無掛證' : $row[19];
        $licenceFab = empty($row[19])? '' : $row[17];
        $licenceLocal = empty($row[19])? '' : $row[18];
        $licenceDept = empty($row[19])? '' : $row[20];
        // 如果"不是""無掛證"
        if($licenceNumberCode != '無掛證'){
            // 如果找不到該人，表"離職"
            if(empty($owner)){
                // 將資料變成陣列
                $dataList = [
                    '工號' => $row[6],
                    '姓名' => $row[7],
                    '單位代碼'  => $row[4],
                    'Hr單位代碼'  => '離職',
                    '掛證單位代碼'  => $licenceNumberCode,
                    '掛證棟別'  => $licenceFab,
                    '掛證廠別'  => $licenceLocal,
                    '掛證單位名稱'  => $licenceDept,
                    '證照名稱'  => $row[11],
                    '比對'  => '請確認',
                ];
                // 儲存成陣列
                $reData[] = $dataList;

            }else{
                // 如果有該人員資料，且部門與系統部門不同
                if(($owner['dept_no'] != $row[4])){
                    // 將資料變成陣列
                    $dataList = [
                        '工號' => $row[6],
                        '姓名' => $row[7],
                        '單位代碼'  => $row[4],
                        'Hr單位代碼'  => $owner['dept_no'],
                        '掛證單位代碼'  => $licenceNumberCode,
                        '掛證棟別'  => $licenceFab,
                        '掛證廠別'  => $licenceLocal,
                        '掛證單位名稱'  => $licenceDept,
                        '證照名稱'  => $row[11],
                        '比對'  => '請確認',
                    
                    ];
                    // 儲存成陣列
                    $reData[] = $dataList;
                
                }else{
                    // 如果相同則跳過
                    continue;
                }

            }
        }else{
            // 如果"無掛證"，則非管控，即跳過。
            continue;
        }
    }
    if(empty($reData)){
        $reData = '皆無異動';
    }
    return $reData;
}



// 看POST過來的資料，先判定該資料是否存在，如果存在，則進行相對應的函式。
if (isset($_FILES['licenceFile'])) {

    $reData = processDataFile('licenceFile');
};


// 以下為ajax回傳的邏輯
header('Content-Type: application/json; charset=utf-8');
echo json_encode($reData);
exit();


function showEmpId($request){
    $pdo = pdo_hrdb();

    $emp_id = trim($request);
    $emp_id_length = mb_strlen($request);
    if($emp_id_length == 7){
        $emp_id = '0'.$emp_id;
    }elseif($emp_id_length != 8){
        return FALSE;
    }
    $sql = "SELECT u.*,  
                s2.emp_id AS s2_emp_id, s2.cname AS s2_cname, s2.emp_scope AS s2_emp_scope, s2.dept_no AS s2_dept_no, s2.emp_dept AS s2_emp_dept, s2.emp_sub_scope AS s2_emp_sub_scope
            FROM staff u
            LEFT JOIN staff s2 ON u.omager = s2.emp_id
            WHERE u.emp_id = ? ";
    $stmt = $pdo->prepare($sql);
    try{
        $stmt->execute([$emp_id]);
        $search = $stmt->fetch();
        return $search;
    }catch(PDOException $e){
        echo $e->getMessage(); 
    }
}


?>
