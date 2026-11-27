<!-- 此分業主要是統一調整CSS或是其他共同事項 -->
<?php
    // 時區設定
    date_default_timezone_set('Asia/Taipei');
    // 今天的年月日
    $today = date("Y-m-d");
    // 明天的年月日
    $nextDay = date("Y-m-d", strtotime($today . " +1 day"));
    // 現在的日
    $nowDate = date('d');
    // 現在的時
    $nowHour = date('H');
    // 現在的分
    $nowMin = date('i');
    // 取當月的最大日(變色用)
    $lastDayOfMonth = date('t');
    // 最大的時(變色用)
    $hour = 24;
    // 最大的分(變色用)
    $min = 60;
    // 顏色的最大數為255。(簡化使用)
    $rgb = 255;
    $red = intval($rgb * ($nowDate / $lastDayOfMonth));
    // 綠色為打開時間的當下月為基礎。
    $green = intval($rgb * ($nowHour / $hour));
    // 藍色為打開時間的當下日為基礎。
    $blue= intval($rgb * ($nowMin / $min));
?>
<style>
/* 標題動態變色 */
@import url("https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@400;600;700&display=swap");

/* 定義顏色變數 */
:root {
    --blueWord: rgb(41, 98, 255);
}
/* rgb(240, 230, 140); */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* body {
    font-family: "Alumni Sans", sans-serif;
    font-size: 16px;
} */

section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    /* align-items: center; */
    /* min-height: 100vh; */
    /* font-size: 2em; */
    /* background: #212121; */
    color: rgb(15,25,115);
    text-transform: uppercase;
    /* gap: 20px; */
}

h1 {
    font-family: "Chocolate Classical Sans", sans-serif;
}
.tags {
    margin-left: 5px;
}

.text-shadow {
    /* font-style: italic; */
    text-transform: uppercase;
    color: transparent;
    -webkit-text-stroke: rgb(15,25,115);
    -webkit-text-stroke-width: 1px;
    text-shadow: 2px 2px 10px var(--blueWord);
    transition: all 0.5s ease-in-out;
    /* text-align: center; */
    letter-spacing: 0.2em;
    animation: flicker 1s ease-in-out infinite alternate;
}

.text-shadow:hover {
    color: rgb(15,25,115);
}

@keyframes flicker {
    0% {
        opacity: 0.5;
        text-shadow: 2px 2px 10px var(--blueWord);
    }
    100% {
        opacity: 1;
        text-shadow: 2px 2px 20px var(--blueWord);
    }
}

/* 標題動態變色 */
.colorfulH3 {
    text-transform: uppercase;
    /* -225deg 表示渐变的方向，其中 -225deg 表示逆时针旋转225度 */
    background-image: linear-gradient(
        -225deg,
        rgb(62, 234, 254) 0%,
        rgb(102, 153, 255) 30%,
        rgb(153, 102, 218) 65%,
        rgb(51, 204, 255) 70%,
        rgb(255, 255, 255) 100%
    );
    background-size: auto auto;
    background-clip: border-box;
    background-size: 200% auto;
    color: rgb(255, 255, 255);
    background-clip: text;
    text-fill-color: transparent;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: textclip 300s linear infinite;
    display: inline-block;
    font-size: 32px;
    font-weight: bold;
    position: relative;
    z-index: 1;
}

/* 時間標題動態變色 */
#show_time1 {
    text-transform: uppercase;
    background-image: linear-gradient(
        /* -225deg 表示渐变的方向，其中 -225deg 表示逆时针旋转225度 */
        225deg,
        rgba(77, 83, 93, 0.3) 0%,
        rgba(192, 192, 192, 1) 30%,
        rgba(117, 125, 128, 1) 60%,
        rgba(255, 255, 255, 1) 80%,
        rgba(160, 147, 112, 0.8) 100%
    );
    background-size: auto auto;
    background-clip: border-box;
    background-size: 200% auto;
    color: rgb(255, 255, 255);
    background-clip: text;
    text-fill-color: transparent;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: textclip 300s linear infinite;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
}
/* 上兩個動態的指令 */
@keyframes textclip {
    to {
    background-position: 200% center;
    }
}

/* 以下為字體自動換色的參數 */
/* 控制字體自動換色 */
#colorful{
    color: rgb(<?php echo $red ?>, <?php echo $green?>, <?php echo $blue?>);
    font-weight: bold;
}
/* 導入bootstrap Icons */
#delete, #excelUpload {
    font-family:'Bootstrap-icons';
}

    .bgInfo {
        position: relative;
        flex-direction: row;
        height: 55px;
        padding: 0;
        margin: 0;
        border-bottom: 1px solid #c8ced3;
    }
    .bgInfo .nav-item .nav-link,
    .bgInfo .nav-item,
    .bgInfo .navbar-nav .nav-item .nav-link,
    .bgInfo .navbar-nav .nav-item .navbar-brand{
        color:rgba(15, 25, 115, 0.9);

    }
    .bgInfo .nav-item {
        text-align: start;
    }
    .bgInfo .nav-item .nav-link {
        padding-bottom: 0;
        background: 0;
        border: 0;
        
    }
    .bgInfo .nav-item .mainTitle{
        font-weight:bold;
    }
    .bgInfo .nav-item .sideTitle{
        font-size: 12px;
        /* 輕微的文字陰影，模擬柔和感 */
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

</style>