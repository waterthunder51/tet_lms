<?php
// 以下為SSO相關
// // // *** none function group
    function accessDenied($sys_id){
        $url='http://'.$_SERVER['HTTP_HOST'].'/';   // 複製本頁網址藥用
        session_start();
        if(!isset($_SESSION["AUTH"]) || !isset($_SESSION[$sys_id])){
            // header("refresh:0;url={$url}tnESH_SSO/login.php?sys_id={$sys_id}");     // 手動
            header("refresh:0;url={$url}tnESH_SSO/?sys_id={$sys_id}");              // SSOv4自動
            exit;
        }
        return;
    }
    // reload sys_id & local user role
    function accessDenied_sys($sys_id){
        $url='http://'.$_SERVER['HTTP_HOST'].'/';                           // 複製本頁網址藥用
        if(!isset($_SESSION)){                                              // 確認session是否啟動
            session_start();
        }
        if(isset($_SESSION["AUTH"]) && !empty($_SESSION["AUTH"]["pass"])){  // 確認是否完成AUTH/pass => True
            if(isset($_SESSION[$sys_id])){                                  // 如果sys_id已經建立，就返回
                return;
            }else{                                                          // sys_id還沒建立，就導入
                $user = $_SESSION["AUTH"]["user"];
                $pdo = pdo();
                $sql = "SELECT u.*, _site.site_title, _area.area_title,
                    _fab.fab_title, _role.role_title, _idty.idty_title 
                    FROM users u 
                    LEFT JOIN _site ON u.site_id = _site.id
                    LEFT JOIN _area ON u.area_id = _area.id
                    LEFT JOIN _fab ON u.fab_id = _fab.id
                    LEFT JOIN _role ON u.role_id = _role.id
                    LEFT JOIN _idty ON u.idty_id = _idty.id
                    WHERE u.user = ? ";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute([$user]);
                $sys_local_row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
                if($sys_local_row){                                     // 有sys_id的人員權限資料
                    if($sys_local_row["role_id"] != ""){                       // 權限沒被禁用
                        $_SESSION[$sys_id] = $sys_local_row;                // 導入$sys_id指定權限
                    }else{                                              // 權限被禁用
                        echo "<script>alert('{$sys_local_row["cname"]} Local帳號停用，請洽管理員')</script>";
                    }
                }else{                                                  // 沒有sys_id的人員權限資料
                    // echo "<script>alert('{$user} local無資料，請洽管理員')</script>";
                    // header("location:../auth/register.php?user=$user");           // 沒有local資料，帶入註冊頁面
                    // 20240527_確認是否是環安處成員~
                    $user = strtoupper($_SESSION["AUTH"]["user"]);  // strtoupper(大寫)
                    $pdo = pdo_hrdb();

                    // // // 這裡會用到hrdb，以前MSSQL的語法要改成mySQL的語法
                    // // // 例如：
                    // // // FROM [hrDB].[dbo].[HCM_VW_EMP01_hiring] _e
                    // // // LEFT JOIN [hrDB].[dbo].[HCM_VW_DEPT08] _d ON _e.OSHORT = _d.OSHORT
                    // // // 要改成：
                    // // // FROM `hrDB`.`HCM_VW_EMP01_hiring` _e
                    // // // LEFT JOIN `hrDB`.`HCM_VW_DEPT08` _d ON _e.OSHORT = _d.OSHORT
                    
                    $sql = "SELECT s.*
                            FROM `hrDB`.`STAFF` s
                            INNER JOIN `hrDB`.`DEPT` d ON s.dept_no = d.sign_code
                            WHERE s.`user` = ? ";
                    $stmt = $pdo -> prepare($sql);
                    $stmt -> execute([$user]);
                    $esh_mb = $stmt -> fetch(PDO::FETCH_ASSOC);
                    if($esh_mb){
                        $_SESSION[$sys_id]["role_id"] = 2.5;   // tnesh_user
                    }else{
                        $_SESSION[$sys_id]["role_id"] = 3;     // 外部user
                    }
                    return;
                }

                // 20230906_set this point to log logs
                header("refresh:0;url={$url}tnESH_SSO/autoLog.php?sys_id={$sys_id}");
                exit;
            }
        }else{                                                          // 確認AUTH/pass => false
            header("refresh:0;url={$url}tnESH_SSO/login.php?sys_id={$sys_id}");     // 手動
            exit;
        }
        return;
    }
    
    function accessDeniedAdmin($sys_id){
        session_start();
        if(!isset($_SESSION["AUTH"]) || !isset($_SESSION[$sys_id]) || $_SESSION[$sys_id]["role_id"] == "" || $_SESSION[$sys_id]["role_id"] >= "2"){
            header('location:../');
            exit;
        }
        return;
    }

?>