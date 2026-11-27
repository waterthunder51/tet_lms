<?php

// 以下為基本使用的函式
// post資料
// function postsList(){
//     $pdo = pdo();
//     $sql = "SELECT *
//             FROM posts
//             ORDER BY id DESC";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute();
//         $post = $stmt->fetchAll();
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }
// area資料
function areaList(){
    $pdo = pdo();
    $sql = "SELECT _area.*, users.cname FROM _area
            LEFT JOIN users ON users.id = _area.user_id
            ORDER BY id ASC";
            // DISTINCT 過濾重複
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $sites = $stmt->fetchAll();
        return $sites;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
// site資料
function siteList(){
    $pdo = pdo();
    $sql = "SELECT _site.*, users.cname FROM _site
            LEFT JOIN users ON users.id = _site.user_id
            ORDER BY id ASC";
            // DISTINCT 過濾重複
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $sites = $stmt->fetchAll();
        return $sites;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

// fab資料
function fabList(){
    $pdo = pdo();
    $sql = "SELECT _fab.*, users.id AS U_id, users.emp_id, users.cname, _site.id AS S_id, _site.site_title, _area.id AS A_id, _area.area_title
            FROM _fab
            LEFT JOIN users ON _fab.user_id = users.id
            LEFT JOIN _site ON _fab.site_id = _site.id
            LEFT JOIN _area ON _fab.area_id = _area.id
            ORDER BY _fab.id ASC";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $post = $stmt->fetchAll();
        return $post;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

// local資料
// function localList(){
//     $pdo = pdo();
//     $sql = "SELECT _local.*,_fab.id AS F_id,_fab.fab_title AS fab_title,users.id AS use_id,users.emp_id,users.cname 
//             FROM _local
//             LEFT JOIN users ON _local.user_id = users.id
//             LEFT JOIN _fab ON _local.fab_id = _fab.id
//             ORDER BY fab_id";
//     $stmt = $pdo->prepare($sql);
//     try {
//         $stmt->execute();
//         $post = $stmt->fetchAll();
//         return $post;
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

// role資料
function roleList(){
    $pdo = pdo();
    $sql = "SELECT _role.*, users.cname FROM _role
            LEFT JOIN users ON users.id = _role.user_id
            ORDER BY id ASC";
            // DISTINCT 過濾重複
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $sites = $stmt->fetchAll();
        return $sites;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

// idty資料
function idtyList(){
    $pdo = pdo();
    $sql = "SELECT _idty.*, users.cname FROM _idty
            LEFT JOIN users ON users.id = _idty.user_id
            ORDER BY id ASC";
            // DISTINCT 過濾重複
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
        $sites = $stmt->fetchAll();
        return $sites;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

// show各lists使用。
    // $posts = postsList();
    $sites = siteList();
    $areas = areaList();
    $fabs = fabList();
    // $locals = localList();
    $roles = roleList();
    $idtys = idtyList();
?>