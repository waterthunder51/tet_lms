<?php
    require_once("../pdo.php");
    require_once("function.php");
    require_once("../functionHome.php");
    updateRole($_REQUEST);

    echo "<script>alert('『".$_REQUEST["role_title"]."』已更新');</script>";
    header("refresh:0;url=index.php");