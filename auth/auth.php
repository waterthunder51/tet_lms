<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");

    auth($_REQUEST);
    // echo print_r($_REQUEST);
    header("refresh:0;url=../post/index.php");