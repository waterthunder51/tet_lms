<?php
require_once("sso.php");
// 保證，session的啟動
    if(!isset($_SESSION)){
        session_start();
    }
// "管理員"權限：除管理員外，皆無法進入。
    function accessDeniedAdministrator($sys_id){
        if(!isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["sys_id"] != "tet_lms" || $_SESSION[$sys_id]["role_id"] > "1"){
            header('location:../post/');
            return;
            
        }
    }

// "PM"權限：PM以上等級外，皆無法進入。
    function accessDeniedAssistant($sys_id){
        if(!isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["sys_id"] != "tet_lms" || !isset($_SESSION[$sys_id]["role_id"]) || $_SESSION[$sys_id]["role_id"] > "2"){
            header('location:../post/');
            return;
        }
    }

// "區域窗口"權限：區域窗口以上等級外，皆無法進入。
    function accessDeniedModerator($sys_id){
        if(!isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["sys_id"] != "tet_lms" || !isset($_SESSION[$sys_id]["role_id"]) || $_SESSION[$sys_id]["role_id"] > "3"){
            header('location:../post/');
            return;
        }
    }

// "區域窗口"權限：區域窗口以上等級外，皆無法進入。
    function accessDeniedEditor($sys_id){
        if(!isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["sys_id"] != "tet_lms" || !isset($_SESSION[$sys_id]["role_id"]) || $_SESSION[$sys_id]["role_id"] > "4"){
            header('location:../post/');
            return;
        }
    }
// "現場窗口"權限：現場窗口以上等級外，皆無法進入。
function accessOnSiteEditor($sys_id){
    if(!isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["sys_id"] != "tet_lms" || !isset($_SESSION[$sys_id]["role_id"]) || $_SESSION[$sys_id]["role_id"] > "5"){
        header('location:../post/');
        return;
    }
}
// 登入者權限：需登入，才能進入。
    function accessDeniedMember($sys_id){
        if(!isset($_SESSION["AUTH"])){
            header('location:../auth/login.php');
            return;
        }
    }                                

// 這一段是用來抓人事資料
// 注意！使用陣列解包，關鍵字為"$emp_id"。要遵守該原則。
// 範例： $person = array( "emp_id" => "12113829", "cname" => "洪于人" );

function showStaff($request){
    $pdo = pdo_hrdb();
    extract($request);

    $emp_id = trim($emp_id);
    $emp_id_length = mb_strlen($emp_id);
    if($emp_id_length != 8){
        return FALSE;
    }
    $sql = "SELECT u.*,  
                s2.emp_id AS s2_emp_id, s2.cname AS s2_cname, s2.emp_scope AS s2_emp_scope, s2.dept_no AS s2_dept_no, s2.emp_dept AS s2_emp_dept, s2.emp_sub_scope AS s2_emp_sub_scope
            FROM staff u
            LEFT JOIN staff s2 ON u.omager = s2.emp_id
            WHERE u.emp_id = ? ";
    $stmt = $pdo->prepare($sql);
    try{
        $stmt->execute([$emp_id]);
        $search = $stmt->fetch();
        return $search;
    }catch(PDOException $e){
        echo $e->getMessage(); 
    }
}

// Hr資料庫對接後的回傳
function fabCheckHrdb($fab){
    $pdo = pdo();
    $sql = "SELECT _fab.*,_site.id AS s_id, _site.site_title, _area.id AS a_id, _area.area_title
            FROM _fab
            LEFT JOIN _site ON _site.id = _fab.site_id
            LEFT JOIN _area ON _area.id = _fab.area_id
            WHERE _fab.fab_hr = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$fab]);
        $post = $stmt->fetch();
        // echo print_r($post)."<br>";
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

?>