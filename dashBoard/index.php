<?php

?>
<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    // 網站計數器
    require_once("count_visitor.php");

    include("../template/header.php");
    include("../template/nav.php");
    // 共同CSS設置
    include("../template/commonCss.php");

?>
<?php
   $top = '255,51,0,1';
   $bottom = '255,232,78,1';
   $textColor ='255,255,255,1';

if($nowHour >= 19 || $nowHour <= 4){
    $top = '255,235,0,1';
    $bottom = '0,0,0,1';
    $textColor ='255,255,255,1';

}elseif($nowHour >= 11 && $nowHour <= 13){ 
    $top = '255, 255, 0, 1';
    $bottom = '135,206,235,1';
    $textColor ='0,0,0,1';
}

?>
<script>
    // mloading function
    function mloading(){
        $("body").mLoading({    // 開啟loading
            icon: "../../libs/jquery/Wedges-3s-120px.gif",
        }); 
    }
    // All resources finished loading! // 關閉mLoading提示
    window.addEventListener("load", function(event) {
        $("body").mLoading("hide");
    });

    mloading();    // 畫面載入時開啟loading
</script>
<style>
/* 定義按下分業時的顏色 */
.nav-tabs .nav-link.active {
    background: linear-gradient(to bottom, 
        rgba(<?php echo $top ?>) 5%,
        rgba(<?php echo $bottom ?>) 75%
    );
    color: rgba(<?php echo $textColor ?>);
    font-weight: bold;
}

/* 定義下拉時的顏色 */
.accordion-button:not(.collapsed) {
    color: rgba(12,99,228,1);
    background-color: rgba(<?php echo $bottom ?>);
    font-weight: bold;
}

p {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    color: #000;
    z-index: 20;
    /* font-weight: bold; */
}


.tnC {
    /* position: absolute; */
    position: relative;
    width: 100px;
    height: 100px;
    padding: 4px;
    border: 2px solid rgba(255, 230, 100, 1);
    /* top: 50%; */
    /* left: 50%; */
    margin: 10px;
    /* transform: translate(-50%, -50%); */
    border-radius: 50%;
    overflow: hidden;
}

/* rgba(255, 211, 6, 0.7), rgba(255, 0, 0, 0.7) */

.tn {
    position: relative;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(45deg, rgba(255, 211, 6, 0.7), rgba(255, 0, 0, 0.7));
    border-radius: 50%;
}

.tn::before,
.tn::after {
    content: "";
    position: absolute;
    width: <?php echo $basicData['ellipse']."px" ?>;
    height: <?php echo $basicData['ellipse']."px" ?>;
    top: 0;
    left: 50%;
    background-color: rgba(255, 255, 255, .4);
    border-radius: 45%;
    transform: translate(-50%, -101% ) rotate(0);
    animation: rotate 6s linear infinite;
    z-index: 1;
}

.tn::after {
    border-radius: 47%;
    background-color: rgba(255, 255, 255, .9);
    transform: translate(-50%, -101%) rotate(0);
    animation: tnAn 10s linear -5s infinite;
    z-index: 2;
}

@keyframes tnAn {
    50% {
        transform: translate(-50%, -101%) rotate(180deg);
    } 100% {
        transform: translate(-50%, -101%) rotate(360deg);
    }
}

.highlight {
  color: red;
  font-weight: bold;
}

.passCount {
  color: blue;
  font-weight: bold;
}

.highlight-background {
    background-color: #ffeeba; /* 设置你想要的背景颜色 */
}

.color1 {
    background-color: rgb(255,153,51); 
}

.color2 {
    background-color: rgb(255,255,153); /* 设置颜色为红色 */
}

#calendar {
  max-width: 1100px;
  margin: 40px auto;
}

</style>

</head>
<body>
<div class="container">
    <div class="col-12 justify-content-center">
        <div class="col_xl_12 col-12">
            <!-- 抬頭h1的位置 -->
            <div class="row py-0" style="vertical-align:bottom;">
                <div class="col-12 col-md-6">
                    <h3 class="colorfulH3">首頁待定</h3>
                </div>
                <div id="show_time1" class="text-end" style="display:inline-block;">
                    <script>
                        setInterval("show_time1.innerHTML=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);
                    </script>
                </div>
                    <!-- 網站人數 -->
                <div class="text-end" style="display:inline-block; color: rgb(102, 153, 255);">
                    <span>您是第 <?php echo $counter; //輸出計數器 ?> 位訪客！</span>
                </div>
            </div>
            <!--1.看板 -->
            <div class="col-12 justify-content-center rounded bg-light">
                <div class="col-12" id ="">
                    <?php if(isset($member) && $member["role_id"] < 4){ 
                        echo '<div class="text-end" style="">';
                            echo '<a href="create.php" class="btn btn-primary" title="新增檢測時間" ><i class="bi bi-calendar2-week"></i></a>';
                        echo '</div>';
                    } 
                    ?>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<!-- goTop滾動畫面DIV 2/4-->
<div id="gotop">
    <i class="fas fa-angle-up fa-2x"></i>
</div>

</body>
<!-- goTop滾動畫面jquery.min.js+aos.js 3/4-->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- goTop滾動畫面script.js 4/4-->
<script src="../css/script.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script>
var today = new Date(); // 创建一个 Date 对象来表示当前日期和时间
var year = today.getFullYear(); // 获取当前年份
var month = today.getMonth() + 1; // 获取当前月份（注意：月份从 0 开始，所以要加 1）
var day = today.getDate(); // 获取当前日期

// 格式化日期为 'YYYY-MM-DD' 的字符串
var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    // 設置初始日曆格式，
    // 'dayGridMonth': 月视图，以网格形式显示每个日期。
    // 'timeGridWeek': 周视图，以时间网格形式显示每天的安排。
    // 'timeGridDay': 天视图，以时间网格形式显示当天的安排。
    // 'listWeek': 周列表视图，以列表形式显示一周的安排。
    initialView: 'dayGridMonth',
    // 設置初始頁面的日期
    initialDate: formattedDate,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    // 格式似乎是JSON
    events: [
      {
        title: 'All Day Event',
        start: '2024-03-01'
      },
      {
        title: 'Long Event',
        start: '2024-03-07',
        end: '2024-03-10'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        start: '2024-03-09T16:00:00'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        start: '2024-03-16T16:00:00'
      },
      {
        title: 'Conference',
        start: '2024-03-11',
        end: '2024-03-13'
      },
      {
        title: 'Meeting',
        start: '2024-03-12T10:30:00',
        end: '2024-03-12T12:30:00'
      },
      {
        title: 'Lunch',
        start: '2024-03-12T12:00:00'
      },
      {
        title: 'Meeting',
        start: '2024-03-12T14:30:00'
      },
      {
        title: 'Birthday Party',
        start: '2024-03-13T07:00:00'
      },
      {
        title: 'Click for Google',
        url: '../post/index.php',
        start: '2024-03-28'
      }
    ]
  });

  calendar.render();
});

</script>
<script type="text/javascript">

    // console.log(allSiteCom);

    // console.log(allSiteEsh);




    function generateSlices(length) {
        console.log(length);
    var slices = {};
    var colors = ['#3366CC', '#FF0066']; // 定義顏色陣列，可以根據需要擴充
    var colorIndex = 0;

    for (var i = 0; i < length; i++) {
        slices[i] = { color: colors[colorIndex] };
        colorIndex = (colorIndex + 1) % colors.length; // 循環使用顏色
    }
    
    return slices;
}



</script>



<?php include("../template/footer.php"); ?>
