<?php
header('Content-Type: application/json');
// 設定回應格式為 JSON

// 接收前端傳來的 JSON 資料
$jsonInput = file_get_contents('php://input');
$data = json_decode($jsonInput, true); // true 表示解碼成關聯式陣列
// echo print_r($jsonInput);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    // 解碼失敗
    echo json_encode(['success' => false, 'message' => '無法解析傳來的資料。']);
    exit;
}

// 驗證資料結構 (可選，但建議)
if (!isset($data['tableName']) || !isset($data['first']) || !is_array($data['first'])|| !isset($data['second']) || !is_array($data['second'])) {
    echo json_encode(['success' => false, 'message' => '傳來的資料格式不正確。']);
    exit;
}

// 組合要儲存的 JSON 內容
$outputJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // JSON_UNESCAPED_UNICODE 確保中文正常顯示

// 設定儲存路徑和檔名
$filename = 'heatTemperJson.json'; // 例如: myTableData_20231027103000.json
$filePath = $filename;

// 嘗試寫入檔案
if (file_put_contents($filePath, $outputJson) !== false) {
    // 成功
    echo json_encode([
        'success' => true,
        'message' => '檔案儲存成功！',
        'filename' => $filename // 回傳檔名給前端
    ]);
} else {
    // 失敗
    echo json_encode(['success' => false, 'message' => '寫入檔案時發生錯誤。']);
}
?>