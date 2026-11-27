<?php
    // 將"site"資料繞出(統合到functionHome)
    // function siteList(){
    //     $pdo = pdo();
    //     $sql = "SELECT _site.*, users.cname FROM _site
    //             LEFT JOIN users ON users.id = _site.user_id
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
        $sql = "SELECT _site.*, users.cname FROM _site
                LEFT JOIN users ON users.id = _site.user_id
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
    // 儲存"site"資料
    function storeSite($request){
        $pdo = pdo();
        extract($request);
        $sql = "INSERT INTO _site(site_title, remark, flag, user_id, created_at, updated_at)VALUES(?,?,?,?,now(),now())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$site_title, $remark, $flag, $user_id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        // 如果不符合，即回饋並執行以下
    }
    // 刪除"site"資料
    function deleteSite($request){
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM _site WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //from edit.php
    //依ID找出要修改的site內容
    function editSite($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM _site WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
            $site = $stmt->fetch();
            return $site;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    //from editsite call updatesite
    //修改完成的editsite 進行Update
    function updateSite($request){
        $pdo = pdo();
        extract($request);
        $sql = "UPDATE _site
                SET site_title=?, remark=?, flag=?, user_id=?, updated_at=now()
                WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$site_title, $remark, $flag, $user_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
