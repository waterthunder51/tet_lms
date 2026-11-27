<?php 

?>
<?php

    function storeUser($request){
        $pdo = pdo();
        extract($request);

        $sql_check = "SELECT * FROM users WHERE user = ?";
        $stmt_check = $pdo -> prepare($sql_check);
        $stmt_check -> execute([$user]);

        if($stmt_check -> rowCount() >0){     
            // 確認帳號是否已經被註冊掉，用rowCount最快~不要用fetch
            echo "<script>alert('帳號已存在，請重新選擇帳號~')</script>";
            header("refresh:0;url=register.php");
            return;
        }

        $sql = "INSERT INTO users(emp_id, user, cname, site_id, area_id, fab_id, sys_id, pw, role_id, idty_id, created_at)VALUES(?,?,?,?,?,?,?,?,?,?,now())";
        $stmt = $pdo -> prepare($sql);

        if(!isset($sys_id)){
            $sys_id = "ert_pls";
        }
        if(!isset($role_id)){
            $role_id = 5;
        }
        if(!isset($idty)){
            $idty_id = 1;
        }
        if(isset($pw)){
            // 以下為加密
            $pw = sha1(md5($pw));
            // $pw = $pw;
        }else{
            $pw = "";
        }

        try{
            $stmt -> execute([$emp_id, $user, $cname, $site_id, $area_id, $fab_id, $sys_id, $pw, $role_id, $idty_id]);
            echo "<script>alert('註冊成功，請重新登入')</script>";
            if(!isset($_SESSION["AUTH"])){
                // $_SESSION["AUTH"] = $request;
                // require_once("count_visitor.php");      // 網站計數器
            }
            header("refresh:0;url=../dashBoard/");
        }catch(PDOException $e){
            echo $e -> getMessage();
        }

    }

    function auth($request){
        $pdo = pdo();
        extract($request);

        $sql = "SELECT users.*,
                _site.site_title, _site.remark AS s_remark, 
                _area.area_title, _area.remark AS a_remark,
                _fab.fab_title, _fab.remark AS f_remark,
                _role.role_title, _role.remark AS r_remark,
                _idty.idty_title, _idty.remark AS i_remark
                FROM users 
                LEFT JOIN _site ON _site.id = users.site_id
                LEFT JOIN _area ON _area.id = users.area_id
                LEFT JOIN _fab ON _fab.id = users.fab_id
                LEFT JOIN _role ON _role.id = users.role_id
                LEFT JOIN _idty ON _idty.id = users.idty_id
                WHERE user = ?";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute([$user]);
        $row = $stmt -> fetch();

        // 進行LDAP驗證
        // 以下為使用LDAP驗證的方式
        // $bPass = checkPasswordByAD($request);
        $bPass = extract($request);

        // LDAP驗證失敗後改驗證local_data
        if(!$bPass){
            if($row){
                // $pw = $pw;
                $pw = sha1(md5($pw));
                if(($pw == $row["pw"]) && !empty($row["pw"])){

                    if($row["role_id"] <> ""){
                        $_SESSION["AUTH"] = $row;
                        $_SESSION["AUTH"]["bPass"] = $bPass;
                        echo "<script>alert('Local登入成功~')</script>";
                        require_once("count_visitor.php");      // 網站計數器

                    }else{
                        echo "<script>alert('Local帳號停用，請洽管理員')</script>";
                        return;
                    }
                    
                }else{
                    echo "<script>alert('Local帳號或密碼錯誤')</script>";
                    return;
                }
            }else{
                echo "<script>alert('NT帳號或密碼錯誤 或 Local帳號不存在~')</script>";
                return;
            }
        }else{
            // 驗證通過-套用user資料
            if(!$row){
                echo "<script>alert('帳號資料不存在，請接續完成資料更新~')</script>";
                // 帶入註冊頁面
                // header("refresh:0;url=register.php?user=$user");     // 常常失效改用下面
                header("location:./register.php?user=$user");

            }else{
                if($row["role_id"] <> ""){
                    $_SESSION["AUTH"] = $row;
                    $_SESSION["AUTH"]["bPass"] = $bPass;
                    echo "<script>alert('LDAP驗證登入成功~')</script>";
                    require_once("count_visitor.php");      // 網站計數器

                }else{
                    echo "<script>alert('帳號停用，請洽管理員')</script>";
                }
            }
            return;
        } 
    }

    // 冠勳加持
        //AD
        $gsServer_Domain = "cminl.oa";
        $gsServer_AD = "CMINLLDAP.LOCAL";
    //以AD認證檢查密碼
    // function checkPasswordByAD($sUserName, $sPassword){
    function checkPasswordByAD($request){

        // global $gsDir_Local;
        global $gsServer_Domain, $gsServer_AD;

        extract($request);
        // $sAccount_AD = $sUserName;
        // $sPassword_AD = $sPassword;
        $sAccount_AD = $user;
        $sPassword_AD = $pw;

        // connect to AD server
        $ldapconn = ldap_connect($gsServer_AD) or die("Could not connect to AD server.");
        $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if(@ldap_bind($ldapconn, $sAccount_AD."@".$gsServer_Domain ,$sPassword_AD)){
                //echo "password correct!";
                $bPass = true;
            }
            else{
                //echo "wrong password!";
                $bPass = false;
        }

        ldap_close($ldapconn);

        return $bPass;
    }

    function editUser($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            return $user;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function updateUser($request, $member){
        $pdo = pdo();
        extract($request);
        $sql_check = "SELECT * FROM users WHERE id=?";
        $stmt_check = $pdo -> prepare($sql_check);
        $stmt_check -> execute([$id]);
        $row = $stmt_check -> fetch();

        if(!isset($resetPw) || $resetPw != "true"){
            if($pw != null ){     
                $pw = sha1(md5($pw));
            }else{
                // 未設定密碼，就沿用密碼
                $pw = $row["pw"];
            }
        }else{
            $pw = "";
        }

        $sql = "UPDATE users SET emp_id=?, user=?, cname=?, site_id=?, area_id=?, fab_id=?, sys_id=?, pw=?, role_id=?, idty_id=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$emp_id, $user, $cname, $site_id, $area_id, $fab_id, $sys_id, $pw, $role_id, $idty_id, $id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        // 管理者編輯自己的資料時，假如..&&..就更新自己的site_title
        if(($member["id"] == $row["id"]) && ($member["area_id"] != $area_id)){
            $sql = "SELECT * FROM _area WHERE id = ?";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([$area_id]);
            $row_site = $stmt -> fetch();
            // $_SESSION["AUTH"] = $row_site;
            $member["area_title"] = $row_site["area_title"];
            $member["area_id"] = $area_id;
        }

    }

    function showAllUsers(){
        $pdo = pdo();
        $sql = "SELECT users.*, _site.site_title, _site.remark AS s_remark, 
                _area.area_title, _area.remark AS a_remark,
                _fab.fab_title, _fab.remark AS f_remark,
                _role.role_title, _role.remark AS r_remark,
                _idty.idty_title, _idty.remark AS i_remark
                FROM users
                LEFT JOIN _site ON _site.id = users.site_id
                LEFT JOIN _area ON _area.id = users.area_id
                LEFT JOIN _fab ON _fab.id = users.fab_id
                LEFT JOIN _role ON _role.id = users.role_id
                LEFT JOIN _idty ON _idty.id = users.idty_id
                ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute();
            $users = $stmt->fetchAll();
            return $users;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    
    function deleteUser($request){
        $pdo = pdo();
        extract($request);
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$id]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    

    function styleIdentify($user){
        $styleNewRid = $user["role_id"] == 0 ?'background-color:rgb(255, 255, 0)':'';
        $styleNewIid = $user["idty_id"] == 10 ?'background-color:rgb(255, 183, 197)':'';
        $colorfull =[
            "role_id" => $styleNewRid,
            "idty_id" => $styleNewIid,
        ];
        return $colorfull;
    }
?>