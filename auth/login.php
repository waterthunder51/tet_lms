<?php 
require_once("../pdo.php");
require_once("../functionAuth.php");
require_once("../functionHome.php");
// include("../template/header.php");
// include("../template/nav.php");
// 共同CSS設置
// include("../template/commonCss.php");
accessDenied_sys($sys_id);
header("refresh:0;url=../");
    exit;
?>
