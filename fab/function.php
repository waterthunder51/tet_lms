<?php
// 版本資訊
// 2023.11.29_導入Hr資料庫，大量相關邏輯進行修正。

?>
<?php

    // for index頁面使用：為show出資料庫"_fab"。(統合到functionHome)
    // function showAllFabs(){
    //     $pdo = pdo();
    //     $sql = "SELECT _fab.*, users.id AS U_id, users.emp_id, users.cname, 
    //                     _site.id AS S_id, _site.site_title, _area.id AS A_id, _area.area_title
    //             FROM _fab
    //             LEFT JOIN users ON _fab.user_id = users.id
    //             LEFT JOIN _site ON _fab.site_id = _site.id
    //             LEFT JOIN _area ON _fab.area_id = _area.id
    //             ORDER BY _fab.id";
    //     $stmt = $pdo->prepare($sql);
    //     try {
    //         $stmt->execute();
    //         $fabs = $stmt->fetchAll();
    //         return $fabs;
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //     }
    // }
    // function showAllSites(){
    //     $pdo = pdo();
    //     $sql = "SELECT * FROM _site
    //             ORDER BY id";
    //     $stmt = $pdo->prepare($sql);
    //     try {
    //         $stmt->execute();
    //         $fabs = $stmt->fetchAll();
    //         return $fabs;
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //     }
    // }

    // function showAllAreas(){
    //     $pdo = pdo();
    //     $sql = "SELECT *  FROM _area
    //             ORDER BY id";
    //     $stmt = $pdo->prepare($sql);
    //     try {
    //         $stmt->execute();
    //         $fabs = $stmt->fetchAll();
    //         return $fabs;
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //     }
    // }


    // for index頁面使用：為catch來自index頁面的 name="submit"指示。store相關data於資料庫"_fab"。
    function storeFab($request){
        // session_start();
        $pdo = pdo();
        extract($request);
        $sql = "INSERT INTO _fab(site_id,area_id,fab_title,fab_hr,remark,local_connect,flag,user_id,created_at,updated_at)VALUES(?,?,?,?,?,?,?,?,now(),now())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$site_id,$area_id,$fab_title,$fab_hr,$remark,$flag,$local_connect,$user_id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    // for index頁面使用：為catch來自index頁面的 name="delete"指示。delete相關data於資料庫"_fab"。
    function deleteFab($request){
        // session_start();
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM _fab WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // for edit頁面使用："id"是catch來自為資料庫"categories.id"。edit相關data於資料庫"_fab"。
    function editFab($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM _fab WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
            $site = $stmt->fetch();
            return $site;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    // for updata頁面使用；為catch來自edit頁面回傳各項目修改data；"id"是catch來自為資料庫"_fab.id"。
    function updateFab($request){
        $pdo = pdo();
        extract($request);
        $sql = "UPDATE _fab
                SET site_id=?, area_id=?, fab_title=?,fab_hr=?, remark=?, local_connect=?, flag=?, user_id=?, updated_at=now()
                WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$site_id, $area_id, $fab_title, $fab_hr, $remark, $local_connect, $flag, $user_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
//分頁工具
function page_div($start,$per){
    $pdo = pdo();
    $sql = "SELECT _fab.*,users.id AS U_id,users.emp_id,users.cname,
                    _site.id AS S_id, _site.site_title, _area.id AS A_id, _area.area_title
            FROM _fab
            LEFT JOIN users ON _fab.user_id = users.id
            LEFT JOIN _site ON _fab.site_id = _site.id
            LEFT JOIN _area ON _fab.area_id = _area.id
            ORDER BY _fab.id";
    $stmt = $pdo -> prepare($sql.' LIMIT '.$start.', '.$per); //讀取選取頁的資料
    try {
        $stmt->execute();
        $rs = $stmt->fetchAll();
        return $rs;
    }catch(PDOException $e){
        echo $e->getMessage(); 
    }
}
?>