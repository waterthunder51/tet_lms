<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    updateSite($_REQUEST);
    
    echo "<script>alert('『".$_REQUEST["site_title"]."』資訊已更新');</script>";
    header("refresh:0;url=index.php");