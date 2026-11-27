<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    // echo print_r($_REQUEST);
    // echo print_r($_SESSION[$sys_id]["id"]);
    if(isset($_SESSION[$sys_id])){
        $member = $_SESSION[$sys_id];
    } 

    
    updateUser($_REQUEST, $member);
    echo "<script>alert('『".$_REQUEST["emp_id"].'_'.$_REQUEST["cname"]."』資訊已更新');</script>";
    header("refresh:0;url=index.php");