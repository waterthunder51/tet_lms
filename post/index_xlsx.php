<?php

// require 不容許回傳值
// 以下為"PhpSpreadsheet"啟動碼

// echo print_r($_POST["htmlTable"]);

// // 导入 PhpSpreadsheet 库
require '../vendor/autoload.php';  

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// echo print_r($_POST);
$data = json_decode($_POST["licenceDownload"], true);
// echo print_r($data);
$now = date("Y-m-d");
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// // 這段是正常Load名單使用
if (array_key_exists('submitDownload', $_POST)){
    // 取各key的名稱為"Title"
    $keys = array_keys($data[0]);
    $column = 1;
    // 將各key的名稱繞開
    foreach ($keys as $key) {
        // 跳過"action"的"Title"
        if ($key === "action") {
            // 跳过特定的 $key
            continue; 
        }
        // 放進去工具中進行產出
        $sheet->setCellValueByColumnAndRow($column, 1, $key);
        $column++;
    }

    // 第二列開始
    $row = 2;
    // 將各資料繞開
    foreach ($data as $item) {
        $col = 1;
        // 將各資料繞開為各值
        foreach ($item as $key => $value) {
            // 跳过特定的 $key
            if ($key === "action") {
                continue; 
            }
            // 放進去工具中進行產出
            $sheet->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }
        // 設定檔案名稱
    $filename = $now.'_證照比對清冊.xlsx';
}


    // 以下為EXCEL規範制式的表頭格式
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');


?>