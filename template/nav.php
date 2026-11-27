<?php
include("header.php");
    $webroot = "..";
    
// echo print_r($_SESSION);

    if(!empty($_SESSION["AUTH"]["pass"]) && !isset($_SESSION[$sys_id])){
        // 套用sys_id權限
        accessDenied_sys($sys_id);
    }
    // 增加共通代碼。
    if(isset($_SESSION[$sys_id])){
        $member = $_SESSION[$sys_id];

    }
    
// 共同CSS設置
include("commonCss.php");
?>


<nav class="navbar navbar-expand-lg navbar-light bgInfo">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $webroot;?>/">
            <img class="navbar-brand-full pl-3" src="../template/tnesh_logo.png?v=<?=time()?>" height="40" width="100" alt="tnESH Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav me-auto sysTitle">
            <li class="nav-item px-1">
                <a class="nav-link px-0 mainTitle" href="<?php echo $webroot;?>/">tnESH-TET 教育訓練系統</a>
                <h6 class="sideTitle">Certification & Personnel Compliance</h6>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" name ="memberStandard" href="#"><i class="fa fa-rss" aria-hidden="true"></i> 公佈欄</a>
                </li>
                <!-- 下拉式選單 -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#trainingLogDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="trainingLogDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" name ="memberStandard" href="#" id="mainMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            『證照管理』
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="mainMenuLink">
                                <li><a class="dropdown-item" href="../post/index.php"><i class="bi bi-person-vcard"></i> 『證照系統』比對『Hr資料庫』</a></li>
                                <!-- <li><a class="dropdown-item" href="../trainLog/index.php"><i class="bi bi-window-stack"></i>『ERT人員』訓練紀錄</a></li> -->
                                <li><hr class="dropdown-divider"></li>
                                <!-- <li><a class="dropdown-item" href="../Personnel/index.php"><i class="bi bi-person-lines-fill"></i>『人員名單』管理</a></li> -->
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- 下拉式選單 -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#heatControlDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="heatControlDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" name ="" href="#" id="heatMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                『熱危害』相關
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="heatMenuLink">
                                <li><a class="dropdown-item" href="../heat/index.php"><i class="fa-solid fa-fire-flame-curved"></i> 熱危害風險等級查詢</a></li>
                                <li><hr class="dropdown-divider"></li>                                    
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- 下拉式選單 -->
                <?php if(isset($member["role_id"]) && $member["role_id"] < 2){ ?>
                <!-- 下拉式選單 -->
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pmControlDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="pmControlDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" name ="" href="#" id="pmMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                PM管理
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="pmMenuLink">
                                <li><a class="dropdown-item" href="../heat/index.php"><i class="fa-solid fa-fire-flame-curved"></i> 熱危害風險等級查詢</a></li>
                                <li><hr class="dropdown-divider"></li>                                    
                            </ul>
                        </li>
                    </ul>
                </div> -->
                <!-- 下拉式選單 -->
                <?php } ?>
                <?php if(isset($member["role_id"]) && $member["role_id"] == 0){ ?>
                <!-- 下拉式選單 -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminControlDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminControlDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" name ="" href="#" id="adminMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                『管理員』管理
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="adminMenuLink">
                                <li><a class="dropdown-item" href="../site/index.php"><i class="bi bi-pin-map"></i> Site管理</a></li>
                                <li><a class="dropdown-item" href="../area/index.php"><i class="bi bi-map"></i> Area管理</a></li>
                                <li><a class="dropdown-item" href="../fab/index.php"><i class="bi bi-buildings"></i> Fab管理</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../role/index.php"><i class="bi bi-key"></i>『權限』管理</a></li>
                                <li><a class="dropdown-item" href="../idty/index.php"><i class="bi bi-person-fill-gear"></i>『職等』管理</a></li>
                                <li><hr class="dropdown-divider"></li>                                    
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- 下拉式選單 -->
                <?php } ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if(!isset($member["role_id"])){ 
                    echo "<li class='nav-item mx-1'>
                            <a href='{$webroot}/auth/login.php' class='navbar-brand track_click' data-item='{$sys_id},NAV,login-btn \ 手動登入' style='font-size: 16px;' name ='memberStandard'>
                            <i class='fa fa-sign-in' aria-hidden='true'></i> 手動登入
                            </a>
                        </li>";
                    echo "<li class='nav-item mx-1'>
                            <a href='{$webroot}/../tnesh_sso/?sys_id={$sys_id}'  class='navbar-brand track_click' data-item='{$sys_id},NAV,login-btn \ SSO登入' style='font-size: 16px;' data-toggle='tooltip' data-placement='bottom' title='SAMv4' >
                            <i class='fa-solid fa-fingerprint'></i> SSO登入
                            </a>
                        </li>";
                } ?>
                <?php if(isset($member["role_id"])){ ?>
                    <!-- 下拉式選單 -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" name ="memberStandard" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php 
                                if($_SESSION["AUTH"]["pass"] != true){
                                    echo '<i class="fa fa-user-secret" aria-hidden="true"></i> ';
                                }
                                if(isset($member["id"])){
                                    echo '<i class="fa fa-user" aria-hidden="true"></i> ';
                                    echo "(".$member["site_title"].") ";
                                    echo $member["cname"].'<sup class="text-danger"> - '.$member["role_id"].'</sup> 你好';
                                }else{
                                    echo '<span class="text-danger"><i class="fa fa-user" aria-hidden="true"></i> 請完成資料建立！</span>';
                                }
                                ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <?php
                                if(!isset($member["id"])){
                                    echo '<li><a class="dropdown-item" href="'.$webroot.'/auth/register.php"><i class="fa fa-user-circle" aria-hidden="true"></i> 建立User資訊</a></li>';
                                }else{
                                    echo '<li><a class="dropdown-item" href="'.$webroot.'/auth/edit.php?id='.$member["id"].'"><i class="fa fa-user-circle" aria-hidden="true"></i> 編輯User資訊</a></li>';

                                }
                                ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php if($member["role_id"] < "2"){ ?>
                                    <li><a class="dropdown-item" href="<?php echo $webroot;?>/auth/index.php"><i class="fa fa-address-card" aria-hidden="true"></i> 管理使用者</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php }  else {?>
                                    <li><a class="dropdown-item" href="<?php echo $webroot;?>/auth/login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> SSO登入</a></li>
                                <?php } ?>
                                <li><a class="dropdown-item" href="<?php echo $webroot;?>/auth/logout.php" class=""><i class="fa fa-sign-out" aria-hidden="true"></i> 登出</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>