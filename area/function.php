<?php
    // for index頁面使用：為show出資料庫"_area"。(統合到首頁'function')
    // function showArea(){
    //     $pdo = pdo();
    //     $sql = "SELECT _area.*, users.cname FROM _area
    //             LEFT JOIN users ON users.id = _area.user_id
    //             ORDER BY id ASC";
    //             // DISTINCT 過濾重複
    //     $stmt = $pdo->prepare($sql);
    //     try {
    //         $stmt->execute();
    //         $sites = $stmt->fetchAll();
    //         return $sites;
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //     }
    // }
    //分頁工具
    function page_div($start,$per){
        $pdo = pdo();
        $sql = "SELECT _area.*, users.cname FROM _area
                LEFT JOIN users ON users.id = _area.user_id
                ORDER BY id ASC";
        $stmt = $pdo -> prepare($sql.' LIMIT '.$start.', '.$per); //讀取選取頁的資料
        try {
            $stmt->execute();
            $rs = $stmt->fetchAll();
            return $rs;
        }catch(PDOException $e){
            echo $e->getMessage(); 
        }
    }
// for index頁面使用：為catch來自index頁面的 name="submit"指示。store相關data於資料庫"_area"。
    function storeArea($request){
        $pdo = pdo();
        extract($request);
        $sql = "INSERT INTO _area(area_title, remark, flag, user_id, created_at, updated_at)VALUES(?,?,?,?,now(),now())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$area_title, $remark, $flag, $user_id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        // 如果不符合，即回饋並執行以下
    }
// for index頁面使用：為catch來自index頁面的 name="delete"指示。delete相關data於資料庫"_area"。
    function deleteArea($request){
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM _area WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //from edit.php
    //依ID找出要修改的area內容
    function editArea($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM _area WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
            $site = $stmt->fetch();
            return $site;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    //from editarea call updatearea
    //修改完成的editarea 進行Update
    function updateArea($request){
        $pdo = pdo();
        extract($request);
        $sql = "UPDATE _area
                SET area_title=?, remark=?, flag=?, user_id=?, updated_at=now()
                WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$area_title, $remark, $flag, $user_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
