<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");

    // 由edit頁面回傳的資料進行輸入
    updateFab($_REQUEST);
    echo "<script>alert('『".$_REQUEST["fab_title"]."』資訊已更新');</script>";
    header("refresh:0;url=index.php");