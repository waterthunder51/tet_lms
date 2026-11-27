<?php
    // 將"shift"資料繞出(統合到functionHome)
    // function roleList(){
    //     $pdo = pdo();
    //     $sql = "SELECT _role.*, users.cname FROM _role
    //             LEFT JOIN users ON users.id = _role.user_id
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
        $sql = "SELECT _role.*, users.cname FROM _role
                LEFT JOIN users ON users.id = _role.user_id
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

    // 儲存"role"資料
    function storeRole($request){
        $pdo = pdo();
        extract($request);
        $sql = "INSERT INTO _role(role_title, count, remark, flag, user_id, created_at, updated_at)VALUES(?,?,?,?,?,now(),now())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$role_title, $count, $remark, $flag, $user_id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        // 如果不符合，即回饋並執行以下
    }
    // 刪除"shift"資料
    function deleteRole($request){
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM _role WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //from edit.php
    //依ID找出要修改的role內容
    function editRole($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM _role WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
            $site = $stmt->fetch();
            return $site;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    //from editrole call updaterole
    //修改完成的editrole 進行Update
    function updateRole($request){
        $pdo = pdo();
        extract($request);
        $sql = "UPDATE _role
                SET role_title=?, count=?, remark=?, flag=?, user_id=?, updated_at=now()
                WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$role_title, $count, $remark, $flag, $user_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


