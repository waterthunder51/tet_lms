<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    

include("../template/nav.php");

$timestamp = time();
$startHeatTemperTime = strtotime('09:30:00');
$endHeatTemperTime = strtotime('18:30:00');
$nowDateYmd = date('Y-m-d', $timestamp);
    $OriginaTemper = [
        'tableName'     => 'heatTemper',
        'date'          => $nowDateYmd,
        'predictCheck'  => 'On',
        'first'         => [
                            'check' => 'On',
                            'send' => '',
                        ],
        'second'        => [
                            'check' => 'On',
                            'send' => '',
                        ],
    ];
    // 導入ESH人事資料JSON資料位置
    $heatTemperFile = "heatTemperJson.json";

    if(file_exists($heatTemperFile)){
        $heatTemperString = file_get_contents($heatTemperFile);
        $heatTemper = json_decode($heatTemperString, true);
        if(empty($heatTemper)){
            $heatTemper = $OriginaTemper;
            // 如果資料日期不是現在
        }elseif($heatTemper['date'] != $nowDateYmd ){
            // echo $nowDateYmd."AA";
            $heatTemper['date'] = $nowDateYmd;
            $heatTemper['predictCheck'] = 'On';
            $heatTemper['first']['check'] = 'On';
            $heatTemper['second']['check'] = 'On';
        }
    }else{
        
        $heatTemper = $OriginaTemper;
    }

?>
</head>
<style>
.listZone {
    background: rgba(255,255,255, 0.7);

}
tr.levelOne td{
    background: rgb(0,255,21) ;
    box-shadow: none;

}
tr.levelTwo td{
    background: rgb(255,255,0);
    box-shadow: none;

}
tr.levelThree td{
    background: rgb(255,170,0);
    color:rgb(255,255,255);
    box-shadow: none;

}
tr.levelFour td{
    background: rgb(255,43,0);
    color:rgb(255,255,255);
    font-weight: bold;
    box-shadow: none;

}


</style>
<body>
<div class="container">
    <div class="col-12 justify-content-center">
        <div class="col_xl_12 col-12">
            <!-- 抬頭h1的位置 -->
            <div class="row py-0" style="vertical-align:bottom;">
                <div class="col-12">
                    <section>
                        <h1 class="text-shadow">『熱危害風險等級查詢』</h1>
                        <div class="tags px-3">
		                    <p class="text-shadow"><small># Heat Index Query</small></p>
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
            <div class="row justify-content-center rounded my-2 bg-light" id="majorBody">
                <p style="text-align: center; margin-top: 20px;" id='heatMark' ></p>

                <div class="col-12" style="height: 500px" >
                    <div id="container" style="height: 100%"></div>
                </div >
                <div class="col-12 rounded listZone" >
                    <div class="row" id='heatRow'>
                        <!-- <table class="table table-light table-striped table-hover table-sm align-middle" id='heatTable' style='text-align: center;'>
                            <thead id='heatThead'></thead>
                            <tbody id='heatTbody'></tbody>
                        </table> -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- 頁面自動更新 -->
<meta http-equiv="refresh" content="1000">
<script src="findTemper.js?v=<?=time()?>"></script>
<script>

    
const heatTemper = <?php echo json_encode($heatTemper); ?>;

// --- 呼叫 weatherForecast 並處理回傳資料 ---
// 使用 IIFE 來讓 await 在 async 函數內執行
(async () => {
    console.log("開始執行 weatherForecast...");
    const heatJson = await weatherForecast(); // 這裡才能正確使用 await
    const arrayLocation = heatJson['records']['Locations'];
    let locationData = [];
    if(arrayLocation.length == 1){
        locationData = arrayLocation[0]['Location'];
    }else{
        arrayLocation.forEach(loc => {
            const locArray = loc['Location'];
            locArray.forEach(lo => {
                locationData.push(lo)
            })
        });
    }

    const localHeat = await localObservation(); // 這裡才能正確使用 await


    const returnData = dataOrganization(locationData);
    const listData = heatHazardIndexn(returnData);
    const drawChart = drawingHeatIndexData(listData);
    drawingHeatIndexChart(drawChart);
    // console.log(heatTemper);
    // console.log(localHeat);
    // console.log(listData);
    pageBarCount(listData, localHeat, 'heat');
    if( isWithinWorkingHours()){
        sendHeadAlert(heatTemper, drawChart, localHeat);
    }
    // sendChatMessage('Test', '', 1);

})();




</script>
<?php 

include("../template/footer.php"); 
?>