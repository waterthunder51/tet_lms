<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    storeIdty($_REQUEST);

    echo "<script>alert('已新增『職等』');</script>";
    header("refresh:0;url=index.php");