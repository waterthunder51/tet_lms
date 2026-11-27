<?php
// 版本資訊
// 2023.12.12_導入Hr資料庫，大量相關邏輯進行修正。

?>
<?php


// // 以下大量函式為相關訓練合格判定使用(移到functionHome)
// // 函式：提取各訓練次數/年。
// function trainCountBenchmark($train) {
//     $benchmarks = [
//         "ERT_Initial"           => "",
//         "ERT_Participant"       => "",
//         "ERT_Refresher"         => "",
//         "Commander_Initial"     => "",
//         "Commander_Refresher"   => "",
//         "ESH_Initial"           => "",
//         "ESH_Refresher"         => "",
//     ];
//     // 將訓練次數繞出來
//     foreach ($train as $trainCounte) {
//         // 定義各參數符合的條件
//         $titleRemark = $trainCounte["title_remark"];
//         // 設置陣列中的數字
//         if (array_key_exists($titleRemark, $benchmarks)) {
//             $benchmarks[$titleRemark] = $trainCounte["train_count"];
//         }
//     }
//     return $benchmarks;
// }
// // 函式：ERT資格是否合格。
// // 判定基準：初訊：當年上課，隔年需復訓；常備：當年需二次；預備：當年需一次。
// function checkErtQualification($ertArray, $trainCounts) {
//     // 擷取$POST內值，先由JSON還原成ARRAY(使用"三元運算子"，如果為空值，即給一個陣列。)
//     $inErtValues = !empty($ertArray["in_ert"]) ? json_decode($ertArray["in_ert"], true) : [];
//     $paErtValues = !empty($ertArray["pa_ert"]) ? json_decode($ertArray["pa_ert"], true) : [];
//     $reErtValues = !empty($ertArray["re_ert"]) ? json_decode($ertArray["re_ert"], true) : [];    
//     // 先定義最大年份(供循環使用)
//     $maxYear = 0;
//     // 定義今年的參數
//     $nowYear = intval(date("Y"));
//     // 如果"inErtValues"沒有值aka沒有"ERT初訓")
//     if( empty($inErtValues) ){
//         return "未參與";
//     }else{
//         // 將inErtValues"aka"ERT初訓"繞出所有資料
//         foreach ($inErtValues as $inErtValue) {
//             // 取出資料的年
//             $year = intval(date("Y", strtotime($inErtValue)));
//             // 如果繞出的年 > 定義的年
//             if ($year > $maxYear) {
//                 // 讓 定義的年 = 繞出的年(用此方法，找出最後的初訓年)
//                 $maxYear = $year;
//             }
//         }
//         // 將"最後的初訓年"aka"maxYear"，存入變數$countY。
//         $countY = $maxYear;

//         // 如果$countY等於現在的年份，則判定為符合資格。(表示今年上課)
//         if ($countY == $nowYear) {
//             return "合格";
//         }
//         // 以下開始是由"最後的初訓年"aka"maxYear"，開始進行檢查，反覆確認到今年。
//         // 當"maxYear"非今年時，先行加上一年。
//         $nextYear = $countY + 1;

//         // 定義各訓練次數
//         $inErtBenchmark = $trainCounts["ERT_Initial"];
//         $paErtBenchmark = $trainCounts["ERT_Participant"];
//         $reErtBenchmark = $trainCounts["ERT_Refresher"];

//         // 使用"while"進行迴圈控制，當 "nextYear" 小於 "currentYear"aka"今年"，此迴圈才會繼續。
//         while ($nextYear < $nowYear) {
//             // 導入"paErtCount" 與 "reErtCount"，進行計算。
//             // 復訓；常備"paErt"：2次/yr；預備"reErt"：1次/yr。
//             $paErtCount = 0;
//             $reErtCount = 0;
//             // 將"paErtValue"aka"復訓-常備"資料繞開。
//             foreach ($paErtValues as $paErtValue) {
//                 // 取出"paErtValue"的年
//                 $paErtYear = intval(date("Y", strtotime($paErtValue)));
//                 // 如果"paErtYear" 等於 "nextYear"
//                 if ($paErtYear == $nextYear) {
//                     // 則 "記數"+1
//                     $paErtCount++;
//                 }
//             }
//             // "paErtCount"大於或等於2時，表示"nextYear"aka"次年"aka"初訓的下一年"的資格合格。
//             if ($paErtCount >= $paErtBenchmark) {
//                 // 將"nextYear"向後推一年。
//                 $nextYear++;
//                 continue;
//             }
//             // 將"reErtValue"aka"復訓-預備"資料繞開。
//             foreach ($reErtValues as $reErtValue) {
//                 // 取出"reErtValue"的年
//                 $reErtYear = intval(date("Y", strtotime($reErtValue)));
//                 // 如果"reErtYear" 等於 "nextYear"
//                 if ($reErtYear == $nextYear) {
//                     // 則 "記數"+1
//                     $reErtCount++;
//                 }
//             }
//             // "reErtCount"大於或等於1時，表示"nextYear"aka"次年"aka"初訓的下一年"的資格合格。
//             if ($reErtCount >= $reErtBenchmark) {
//                 $nextYear++;
//                 // 將"nextYear"向後推一年。
//                 continue;
//             }
//             // 以上皆不符合時，會回傳"不合格"aka"失去ERT資格"
//             return "不合格";
        
//         }
//         // 如果持續繞行到結束，皆符合。則回傳"合格"(迴圈會於今年的前一年停止，表今年是否合格，非今年"無需復訓")
//         return "合格"; 
//     }   
// }

// // 函式：指揮官資格是否合格。
// // 判定基準：初訊：當年上課，隔年需復訓；複訓：當年需一次。
// function checkComQualification($comArray, $trainCounts) {
//     // 擷取$POST內值，先由JSON還原成ARRAY(使用"三元運算子"，如果為空值，即給一個陣列。)
//     $inComValues = !empty($comArray["in_com"]) ? json_decode($comArray["in_com"], true) : [];
//     $paComValues = !empty($comArray["re_com"]) ? json_decode($comArray["re_com"], true) : [];

//     // 代入checkErtQualification()"ERT資格是否合格"，確認資格。
//     $DetermineEligibility = checkErtQualification($comArray, $trainCounts);
//     if( $DetermineEligibility == "不合格" || $DetermineEligibility == "未參與"){
//         return "未完成ERT初訓";
//     }

//     // 找到最大的年份並提取該值
//     $maxYear = 0;
//     // 定義今年的參數
//     $nowYear = intval(date("Y"));
//     // 如果"inComValues"沒有值aka沒有"指揮官初訓")
//     if( empty($inComValues) ){
//         return "未參與";
//     }else{
//         // 將inComValues"aka"指揮官初訓"繞出所有資料
//         foreach ($inComValues as $inComValue) {
//             // 取出資料的年
//             $yearCom = intval(date("Y", strtotime($inComValue)));
//             // 如果繞出的年 > 定義的年
//             if ($yearCom > $maxYear) {
//                 // 讓 定義的年 = 繞出的年(用此方法，找出最後的初訓年)
//                 $maxYear = $yearCom;
//             }
//         }
//         // 將"最後的初訓年"aka"maxYear"，存入變數$countY。
//         $countComY = $maxYear;

//         // 如果$countY等於現在的年份，則判定為符合資格。(表示今年上課)
//         if ($countComY == $nowYear) {
//             return "合格";
//         }

//         // 以下開始是由"最後的初訓年"aka"maxYear"，開始進行檢查，反覆確認到今年。
//         // 當"maxYear"非今年時，先行加上一年。
//         $nextYear = $countComY + 1;
//         // 定義各訓練次數
//         $inComBenchmark = $trainCounts["Commander_Initial"];
//         $paComBenchmark = $trainCounts["Commander_Refresher"];
//         // 使用"while"進行迴圈控制，當 "nextYear" 小於 "currentYear"aka"今年"，此迴圈才會繼續。
//         while ($nextYear < $nowYear) {
//             // 導入"paComCount"進行計算。
//             $paComCount = 0;
//             // 將"paComValue"aka"指揮官-復訓"資料繞開。
//             foreach ($paComValues as $paComValue) {
//                 // 取出"paComValue"的年
//                 $paComYear = intval(date("Y", strtotime($paComValue)));
//                 // 如果"paErtYear" 等於 "nextYear"
//                 if ($paComYear == $nextYear) {
//                     // 則 "記數"+1
//                     $paComCount++;
//                 }
//             }
//             // "paErtCount"大於或等於1時，表示"nextYear"aka"次年"aka"初訓的下一年"的資格合格。
//             if ($paComCount >= $paComBenchmark) {
//                 // 將"nextYear"向後推一年。
//                 $nextYear++;
//                 continue;
//             }
//             // 以上皆不符合時，會回傳"不合格"aka"失去指揮官資格"
//             return "不合格";
        
//         }
//         // 如果持續繞行到結束，皆符合。則回傳"合格"(迴圈會於今年的前一年停止，表今年是否合格，非今年"無需復訓")
//         return "合格"; 
//     }   
// }
    
// // 函式：ESH資格是否合格。
// // 判定基準：初訊：當年上課，隔年需復訓；複訓：當年需一次。
// function checkEshQualification($eshArray, $trainCounts) {
//     // 擷取$POST內值，先由JSON還原成ARRAY。(使用"三元運算子"，如果為空值，即給一個陣列。)
//     $inEshValues = !empty($eshArray["in_esh"]) ? json_decode($eshArray["in_esh"], true) : [];
//     $paEshValues = !empty($eshArray["re_esh"]) ? json_decode($eshArray["re_esh"], true) : [];

//     // 找到最大的年份並提取該值
//     $maxYear = 0;
//     // 定義今年的參數
//     $nowYear = intval(date("Y"));
//     // 如果"inEshValues"沒有值aka沒有"指揮官初訓")
//     if( empty($inEshValues) ){
//         return "未參與";
//     }else{
//         // 將inEshValues"aka"ESH初訓"繞出所有資料
//         foreach ($inEshValues as $inEshValue) {
//             // 取出資料的年
//             $yearEsh = intval(date("Y", strtotime($inEshValue)));
//             // 如果繞出的年 > 定義的年
//             if ($yearEsh > $maxYear) {
//                 // 讓 定義的年 = 繞出的年(用此方法，找出最後的初訓年)
//                 $maxYear = $yearEsh;
//             }
//         }
//         // 將"最後的初訓年"aka"maxYear"，存入變數$countY。
//         $countEshY = $maxYear;

//         // 如果$countY等於現在的年份，則判定為符合資格。(表示今年上課)
//         if ($countEshY == $nowYear) {
//             return "合格";
//         }
//         // 以下開始是由"最後的初訓年"aka"maxYear"，開始進行檢查，反覆確認到今年。
//         // 當"maxYear"非今年時，先行加上一年。
//         $nextYear = $countEshY + 1;
//         // 定義各訓練次數
//         $inEshBenchmark = $trainCounts["ESH_Initial"];
//         $paEshBenchmark = $trainCounts["ESH_Refresher"];
//         // 使用"while"進行迴圈控制，當 "nextYear" 小於 "currentYear"aka"今年"，此迴圈才會繼續。
//         while ($nextYear < $nowYear) {
//             // 導入"paEshCount"進行計算。
//             $paEshCount = 0;
//             // 將"paEshValue"aka"指揮官-復訓"資料繞開。
//             foreach ($paEshValues as $paEshValue) {
//                 // 取出"paComValue"的年
//                 $paEshYear = intval(date("Y", strtotime($paEshValue)));
//                 // 如果"paErtYear" 等於 "nextYear"
//                 if ($paEshYear == $nextYear) {
//                     // 則 "記數"+1
//                     $paEshCount++;
//                 }
//             }
//             // "paErtCount"大於或等於1時，表示"nextYear"aka"次年"aka"初訓的下一年"的資格合格。
//             if ($paEshCount >= $paEshBenchmark) {
//                 // 將"nextYear"向後推一年。
//                 $nextYear++;
//                 continue;
//             }
//             // 以上皆不符合時，會回傳"不合格"aka"失去指揮官資格"
//             return "不合格";
        
//         }
//         // 如果持續繞行到結束，皆符合。則回傳"合格"(迴圈會於今年的前一年停止，表今年是否合格，非今年"無需復訓")
//         return "合格"; 
//     }   
// }

// // shift資料(移到functionHome)
// function shiftSeach($data){
//     $pdo = pdo();
//     extract($data);
//     $sql = "SELECT * FROM _shift 
//             WHERE id = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$shift]);
//         $post = $stmt->fetch();
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// // 訓練次數資料(移到functionHome)
// function trainCount($data){
//     $pdo = pdo();
//     extract($data);
//     $sql = "SELECT _local.*, _fab.id AS f_id, _fab.fab_title
//             FROM _local
//             LEFT JOIN _fab ON _local.fab_id = _fab.id
//             WHERE _local.fab_id = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$id]);
//         $post = $stmt->fetchAll();

//         // echo print_r($post).'<br>';
//         $ertCount = 0;
//         $comCount = 0;
//         foreach($post as $pos){
//             $ertCount += $pos["ert_count"];
//             $comCount += $pos["com_count"];
//         }
//         $reCount = [
//             "fab" => $id,
//             "ertCount"  => $ertCount,
//             "comCount"  => $comCount,
//         ];
//         return $reCount;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// // 導入棟別與廠區，匯出該廠區相關資料(移到functionHome)
// function intoAccount($fab,$local){
//     $pdo = pdo();
//     // echo $fab."_".$local.'<br>';
//     $sql = "SELECT _fab.* , _local.id AS l_id, _local.local_title, _local.flag AS l_flag, _local.ert_count, _local.com_count, _local.remark AS r_local
//             FROM _fab
//             LEFT JOIN _local ON _local.fab_id = _fab.id
//             WHERE _fab.id = ? && _local.local_title = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$fab,$local]);
//         $post = $stmt->fetch();
//         $reFabLocal = [
//             'fab' => $post['id'],
//             'fab_title' => $post['fab_title'],
//             'f_flag' => $post['flag'],
//             'local' => $post['l_id'],
//             'local_title' => $post['local_title'],
//             'local_remark' => $post['r_local'],
//             'l_flag' => $post['l_flag'],
//             'ert_count' => $post['ert_count'],
//             'com_count' => $post['com_count'],
//         ];
//         // echo print_r($post).'<br>';
//         return $reFabLocal;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }
// 帶入"棟別"資料，將相同"棟別"的篩選出"廠區"並繞出來。
function fabCountTrain($fab){
    $pdo = pdo();
    $sql = "SELECT _fab.* , _local.id AS l_id, _local.local_title, _local.flag AS l_flag, _local.ert_count, _local.com_count
            FROM _fab
            LEFT JOIN _local ON _local.fab_id = _fab.id
            WHERE _fab.id = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$fab]);
        $post = $stmt->fetchAll();
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
// 帶入"棟別"與"ESH"資料，將相同"棟別"的篩選出"ESH"並繞出來。
function fabWithEsh($fab, $word ){
    $pdo = pdo();
    $sql = "SELECT _fab.* , _local.id AS l_id, _local.local_title, _local.flag AS l_flag, _local.ert_count, _local.com_count, _local.remark
            FROM _fab
            LEFT JOIN _local ON _local.fab_id = _fab.id
            WHERE _fab.id = ? AND _local.remark = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$fab, $word]);
        $post = $stmt->fetchAll();
        // echo print_r($post)."<br>";
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
// 將"工號"代入，繞出新建資料的時間用
function postsCreated($emp){
    $pdo = pdo();
    $sql = "SELECT * FROM postshr
            WHERE postshr.emp_id = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$emp]);
        $post = $stmt->fetch();
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

// 控制<p>內文的文字，字型大小，於控制百分比輸出
function checkColorSize($color, $textData) {
    if ($color == 100) {
        $fontColor = '';
        // 此處為向下取整數，利於"100.00"改為"100"，而挑用向下取整數(aka"floor")是因為避免四捨五入進位
        $showPercent = floor($color);
    } else {
        $fontColor = 'color:rgb(255,0,0);';
        $showPercent = sprintf("%04.1f", $color);
    }
    // 消除"空白"
    $text = trim($textData);
    // 確認"字數"
    $charCount = mb_strlen($text, 'UTF-8');
    if($charCount > 2){
        $fontSize = 'font-size: 18px;';
    }else{
        $fontSize = 'font-size: 20px;';
    }
    $style = $fontColor.' '.$fontSize;
    $font = [
        'style' => $style,
        'percent' => $showPercent,
    ];

    return $font;
}

// // Hr資料庫對接後的回傳(移到functionHome)
// function checkFab($fab){
//     $pdo = pdo();
//     $sql = "SELECT *
//             FROM _fab
//             WHERE _fab.fab_hr = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$fab]);
//         $post = $stmt->fetchAll();
//         // echo print_r($post)."<br>";
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// function checkLocal($fabId, $local){
//     $pdo = pdo();
//     $sql = "SELECT *
//             FROM  _local
//             WHERE _local.fab_id = ? AND _local.local_title = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$fabId, $local]);
//         $post = $stmt->fetchAll();
//         // echo print_r($post)."<br>";
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// function checkShift($shift){
//     $pdo = pdo();
//     $sql = "SELECT *
//             FROM  _shift
//             WHERE _shift.shift_hr = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$shift]);
//         $post = $stmt->fetchAll();
//         // echo print_r($post)."<br>";
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// function checkEmploy($employ){
//     $pdo = pdo();
//     $sql = "SELECT *
//             FROM  _employ
//             WHERE _employ.employ_title = ?";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute([$employ]);
//         $post = $stmt->fetchAll();
//         // echo print_r($post)."<br>";
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// // 移除計算式(移到functionHome)
// function CountPeason($pairCount, $basicData, $number){
//     $countShift = $pairCount * $basicData['shiftCount'];
//     $numPeason = number_format($number / ($countShift) *100, 2);
//         // 計算值與"100"進行比較，取"最小"。
//     $numPeason = number_format(min($numPeason, 100), 2);
//     $numIntervals = $number / ($countShift) * $basicData['basic'];
//     $num = number_format($numIntervals + $basicData['waterLow'], 2);
//     $numC = ($number == 0) ? $num : $num+2;
//     if( $num >= 100 ){
//         $num = 100;
//     }
//     if( $numC >= 100 ){
//         $numC = 100;
//     }
//     $percent = [
//         "percentNumP" => $numPeason,
//         "percentNumA" => $num,
//         "percentNumC" => $numC,
//     ];
//     return $percent;

// };


?>