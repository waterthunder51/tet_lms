<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    storeArea($_REQUEST);

    echo "<script>alert('已新增廠區');</script>";
    header("refresh:0;url=index.php");