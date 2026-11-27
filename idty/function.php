<?php
// idty資料(統合到functionHome)
    // function idtyList(){
    //     $pdo = pdo();
    //     $sql = "SELECT _idty.*, users.cname FROM _idty
    //             LEFT JOIN users ON users.id = _idty.user_id
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
        $sql = "SELECT _idty.*, users.cname FROM _idty
                LEFT JOIN users ON users.id = _idty.user_id
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

    // site項目--新增 220602
    function storeIdty($request){
        // session_start()
        // 為啟動站存於 伺服器端。
        // 主要用途為後續$_SESSION調用時使用。
        // 注意，該調用需於最前端，且不可重複調用。
        // 如果接受到儲存指令，則進行以下判斷
        // 轉 accessDeniedAdmin()。
        $pdo = pdo();
        extract($request);
        $sql = "INSERT INTO _idty(idty_title, access, remark, flag, user_id, created_at, updated_at)VALUES(?,?,?,?,?,now(),now())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$idty_title, $access, $remark, $flag, $user_id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        // 如果不符合，即回饋並執行以下
    }

    function deleteIdty($request){
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM _idty WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //from edit.php
    //依ID找出要修改的site內容
    function editIdty($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM _idty WHERE id = ?";
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
    function updateIdty($request){
        $pdo = pdo();
        extract($request);
        $sql = "UPDATE _idty
                SET idty_title=?, access=?, remark=?, flag=?, user_id=?, updated_at=now()
                WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$idty_title, $access, $remark, $flag, $user_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

