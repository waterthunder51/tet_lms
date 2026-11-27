<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    // echo print_r($_REQUEST);
    storeUser($_REQUEST);
