<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    

include("../template/nav.php");

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- post -->
<style>

.error {
    color: rgb(255, 0, 0); /* 红色字体 */
    font-weight: bold;
}

#loginRequired {
    position: relative;
    -webkit-box-reflect: below -8px linear-gradient(transparent, rgba(0,0,0,.3));
    font-size: 32px;
}
#loginRequired span {
  font-family: 'Alfa Slab One', cursive;
  position: relative;
  display: inline-block;
  /* text-transform: uppercase; */
  animation: waviy 1s infinite;
  animation-delay: calc(.1s * var(--i));
  
}
@keyframes waviy {
  0%,40%,100% {
    transform: translateY(0)
  }
  20% {
    transform: translateY(-20px)
  }
}
</style>
<?php

// 抓取時間資料
$currentYear = date('Y');
$currentMonth = date('m');
$percentMonth = $currentMonth /12 ;
$currentDay = date('d');
// 日天數
$daysInDay = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$percentDay = $currentDay /$daysInDay ;
$currentHour = date('H');
$percentHour = $currentHour /24 ;

// 設定顏色，與抓取的顏色資料進行混編
$red = round(255 * $percentMonth);
$blue = round(255 * $percentDay);
$green = round(255 * $percentHour);
// 設定RGB一導入後續資料的陣列
$baiceColor = [
    'red' => $red,
    'blue' => $blue,
    'green' => $green,
];

// 設定更新後的文字陣列
$showWords = [
    '1' => '請',
    '2' => '進',
    '3' => '行',
    '4' => '系',
    '5' => '統',
    '6' => '登',
    '7' => '入',
];
$numberOfKeys = count($showWords);

// 如果人事資料更新成功，自動跳動態顏色
function colorful($keyWord, $color, $number){
    $percentColor = 1 - ($keyWord / $number);
    $redNum = round($color['red'] + ($color['red'] * $percentColor));
    $greenNum = round($color['green'] + ($color['green'] * $percentColor));
    $blueNum = round($color['blue'] + ($color['blue'] * $percentColor));

    $showRed = $redNum > 255 ? $redNum - 255 : $redNum;
    $showGree = $greenNum > 255 ? $greenNum - 255 : $greenNum;
    $showBlue = $blueNum > 255 ? $blueNum - 255 : $blueNum;

    $colorFin = 'rgb('.$showRed.','.$showGree.','.$showBlue.')';
    return $colorFin;
    
}

?>

</head>
<body>
<div class="container">
    <div class="col-12 justify-content-center">
        <div class="col_xl_12 col-12">
            <!-- 抬頭h1的位置 -->
            <div class="row py-0" style="vertical-align:bottom;">
                <div class="col-12">
                    <section>
                        <h1 class="text-shadow" id="spsH3">『證照系統』比對『Hr資料庫』</h1>
                        <div class="tags px-3">
		                    <p class="text-shadow"><small># Comparison of Licence System with HR Database</small></p>
	                    </div>
                    </section>
                </div>
                <div id="show_time1" class="text-end" style="display:inline-block;">
                    <script>
                        setInterval("show_time1.innerHTML=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);
                    </script>
                </div>
            </div>
            <!--1.看板 -->
            <div class="col-12 justify-content-center rounded my-2 bg-light" id="majorBody">
                <!-- 選擇頁簽 -->
                
                <div class="row  align-items-center">
                    <div class="col-12">
                        <?php
                        if(!isset($member)){
                            // 進行完成後，則會顯示更新動畫。
                            echo '<h4 id="loginRequired">掛證人員比對～～';
                            foreach($showWords as $key => $showWord){
                                $color = colorful($key, $baiceColor, $numberOfKeys);
                                echo '<span style="--i:'.$key.'; color: '.$color.';">'.$showWord.'</span>';
                            }
                        }else{
                            echo '<h4 class="colorfulH3">掛證人員比對';
                        }
                        echo '</h4>';
                        ?>
                    </div>
                    <?php
                    echo '<div class="col-11" style="">';
                    echo '<form id="myForm" method="post" action="index_xlsx.php">';
                        echo '<button type="submit" name="submitDownload" id = "download" title="匯出當下資料" class="btn btn-primary" disabled ><i class="bi bi-download"></i></button>';
                        //    下載EXCEL的觸發
                        //    echo '<textarea id="licenceDownload" name="licenceDownload"  class="col-12" style=""></textarea>';
                        echo '<textarea id="licenceDownload" name="licenceDownload"  class="col-12" style="display: none;"></textarea>';
                    echo '</form>';
                    echo '</div>';
                    if(isset($member) && $member["role_id"] < 2){
                        echo '<div class="col-1 text-end">';
                            echo '<a href="#" target="_blank" title="LMS清冊for匯入" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#licenceAdd">';
                                echo '<i class="bi bi-journal-arrow-up"></i>';
                            echo '</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <table id='licence'>
                    <thead>
                        <tr>
                            <!-- <th></th> -->
                            <th>項次</th>
                            <th>工號</th>
                            <th>姓名</th>
                            <th>單位代碼</th>
                            <th>Hr單位代碼</th>
                            <th>掛證單位代碼</th>
                            <th>掛證棟別</th>
                            <th>掛證廠別</th>
                            <th>掛證單位名稱</th>
                            <th>證照名稱</th>
                            <th>比對</th>                           
                        </tr>
                    </thead>
                    <tbody id='licenceTbody'></tbody>
                </table>
            </div>
            
            <!-- goTop滾動畫面DIV 2/4 -->
            <div id="gotop">
                <i class="fas fa-angle-up fa-2x"></i>
            </div>
        </div>
    </div>
</div>

<!-- licence_彈出畫面模組 -->
<div class="modal fade" id="licenceAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- 過長時滾動 -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">匯入『掛證管理系統資料』</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="licenceForm" name="licenceForm" enctype="multipart/form-data" onsubmit="">
            <!-- <form action="ajax_excel.php"  method="post" id="" name="licenceForm" enctype="multipart/form-data" onsubmit=""> -->
            <div class="modal-body px-5">
                <div class="row">
                    <div class="col">
                        <label for="licenceFile" class="form-label">『掛證管理系統』檔案<sup class="text-danger"> *限制為EXCEL檔案</sup></label>
                        
                        <input type="file" name="licenceFile" id="licenceFile" style="font-size: 16px; max-width: 250px;" class="form-control form-control-sm" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>

                    <div class="col-2 d-flex align-items-center">
                        <input type="submit" name="licenceUpload" id="licenceUpload" class="btn btn-outline-info" title="上傳" value="&#xF2C0;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-end">
                    <button type="reset" name="licenceReset" id="licenceReset" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="controlForm.js?v=<?=time()?>"></script>
<?php 
include("../template/footer.php"); 
?>