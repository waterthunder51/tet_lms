<?php

?>

<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");

    // accessDenied_sys($sys_id);
    // accessDeniedAssistant($sys_id);
    
    if(isset($_POST["submit"])){
        storeUser($_REQUEST);
    }
    if(isset($_POST["delete"])){
        deleteUser($_REQUEST);
    }

    $showAllUsers = showAllUsers();
    $num = count($showAllUsers);


include("../template/nav.php");

?>
</head>
<?php
   $top = '255,51,0,1';
   $bottom = '255,232,78,1';
   $textColor ='255,255,255,1';

if($nowHour >= 19 || $nowHour <= 4){
    $top = '255,235,0,1';
    $bottom = '0,0,0,1';
    $textColor ='255,255,255,1';

}elseif($nowHour >= 11 && $nowHour <= 13){ 
    $top = '255, 255, 0, 1';
    $bottom = '135,206,235,1';
    $textColor ='0,0,0,1';
}

?>
<style>
/* 定義按下分業時的顏色 */
.nav-tabs .nav-link.active {
    background: linear-gradient(to right, 
        rgba(<?php echo $top ?>) 5%,
        rgba(<?php echo $bottom ?>) 75%
    );
    color: rgba(<?php echo $textColor ?>);
    font-weight: bold;
}

.warning{
    color : red;
}

.roleColor{
    color : rgb(51,204,51);
}


</style>
<?php
$waiters = [];
$members = [];
$unenrolleds = [];
$access     = 0;
$permission = 0;
$suspended  = 0;
foreach($showAllUsers as $user){
    if($user["role_id"] == ''){
        $waiters[] =$user;
        $access ++;
    }elseif($user["role_id"] <= "4"){
        $members[] = $user;
        $permission ++;
    }elseif($user["role_id"] > "4"  && $user["role_id"] < "9"){
        $waiters[] = $user;
        $access ++;
    }elseif($user["role_id"] >= "9"){
        $unenrolleds[] = $user;
        $suspended ++;
    }

} 


?>
<body>
    <div class="" id="top"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 bg-light border p-4 rounded my-2">
                <div class="row">
                    <div class="col-8">
                        <div>
                            <h4 id="colorful">User列表-共 <?php echo $num; ?> 筆</h4>
                        </div>
                    </div>
                    <?php if($member["role_id"] == 0){ ?>
                    <div class="col-md-4 text-end">
                        <div>
                            <a href="#" target="_blank" title="人員資料for新增" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_url"> <i class="fa fa-user-plus"></i></a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <ul class="nav nav-tabs" id="auth" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="accessList" data-bs-toggle="tab" data-bs-target="#access" type="button" role="tab" aria-controls="access" aria-selected="true" title ="新申請人" >Applicants List<?php if($access !== 0){echo '<span class = "warning">【'.$access.'】</span>';} ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="authorizedList" data-bs-toggle="tab" data-bs-target="#authorized" type="button" role="tab" aria-controls="authorized" aria-selected="false" title ="管理清冊">Authorized List</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="suspendedList" data-bs-toggle="tab" data-bs-target="#suspended" type="button" role="tab" aria-controls="suspended" aria-selected="false" title ="停權清冊">Suspended List<?php if($suspended !== 0){echo '<span class = "warning">【'.$suspended.'】</span>';} ?></button>
                    </li>
                </ul>
                <div class="tab-content" id="authTable">
                    <div class="tab-pane fade show active" id="access" role="tabpanel" aria-labelledby="accessList">
                        <div class="col-12 border p-4 rounded " style="background: rgba(255, 204, 0, 0.7);">
                            <table class="table table-light table-striped table-hover table-sm text-center" >
                                <!-- 新人名單 -->
                                <thead> 
                                    <tr>
                                        <th>id_N</th>
                                        <th>emp_id</th>
                                        <th>user</th>
                                        <th>cName</th>
                                        <th>Site_id</th>
                                        <th>Area_id</th>
                                        <th>Fab_id</th>
                                        <th>sys_id</th>
                                        <th>role</th>
                                        <th>idty</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($waiters)){

                                        foreach($waiters as $waiter){ 
                                            echo '<tr>';
                                                echo '<td title="created_at："'.$waiter["created_at"].'">'.$waiter["id"].'</td>';
                                                echo '<td>'.$waiter["emp_id"].'</td>';
                                                echo '<td>'.$waiter["user"].'</td>';
                                                echo '<td>'.$waiter["cname"].'</td>';
                                                echo '<td title="'.$waiter["s_remark"].'">'.$waiter["site_title"].'</td>';
                                                echo '<td title="'.$waiter["a_remark"].'">'.$waiter["area_title"].'</td>';
                                                echo '<td title="'.$waiter["f_remark"].'">'.$waiter["fab_title"].'</td>';
                                                echo '<td>'.$waiter["sys_id"].'</td>';
                                                $styleNew = styleIdentify($waiter);
                                                echo '<td style="'.$styleNew["role_id"].'">';
                                                    echo '<span class="roleColor" >【'.$waiter["role_id"] .'】</span>'.$waiter["role_title"];
                                                echo '</td>';
                                                echo '<td style="'.$styleNew["idty_id"].'">';
                                                    echo $waiter["idty_title"];
                                                echo '</td>';
                                                echo '<td><a href="edit.php?id='.$waiter["id"].'" class="btn btn-sm btn-xs btn-info" title="編輯資料" ><i class="bi bi-brush"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    } else{
                                        echo '<tr>'; 
                                            echo '<td colspan="11">無資料</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="authorized" role="tabpanel" aria-labelledby="authorizedList">
                        <div class="col-12 border p-4 rounded" style="background: rgba(255, 204, 0, 0.7);">
                            <table class="table table-light table-striped table-hover table-sm text-center">
                                <thead> 
                                    <tr>
                                        <th>id_N</th>
                                        <th>emp_id</th>
                                        <th>user</th>
                                        <th>cName</th>
                                        <th>Site_id</th>
                                        <th>Area_id</th>
                                        <th>Fab_id</th>
                                        <th>sys_id</th>
                                        <th>role</th>
                                        <th>idty</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($members)){

                                        foreach($members as $member){ 
                                            echo '<tr>';
                                                echo '<td title="created_at："'.$member["created_at"].'">'.$member["id"].'</td>';
                                                echo '<td>'.$member["emp_id"].'</td>';
                                                echo '<td>'.$member["user"].'</td>';
                                                echo '<td>'.$member["cname"].'</td>';
                                                echo '<td title="'.$member["s_remark"].'">'.$member["site_title"].'</td>';
                                                echo '<td title="'.$member["a_remark"].'">'.$member["area_title"].'</td>';
                                                echo '<td title="'.$member["f_remark"].'">'.$member["fab_title"].'</td>';
                                                echo '<td>'.$member["sys_id"].'</td>';
                                                $styleNew = styleIdentify($member);
                                                echo '<td style="'.$styleNew["role_id"].'">';
                                                    echo '<span class="roleColor" >【'.$member["role_id"] .'】</span>'.$member["role_title"];
                                                echo '</td>';
                                                echo '<td style="'.$styleNew["idty_id"].'">';
                                                    echo $member["idty_title"];
                                                echo '</td>';
                                                echo '<td><a href="edit.php?id='.$member["id"].'" class="btn btn-sm btn-xs btn-info" title="編輯資料" ><i class="bi bi-brush"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    } else{
                                        echo '<tr>'; 
                                            echo '<td colspan="11">無資料</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="suspended" role="tabpanel" aria-labelledby="suspendedList">
                        <div class="col-12 border p-4 rounded" style="background: rgba(255, 204, 0, 0.7);">
                            <table class="table table-light table-striped table-hover table-sm text-center">
                                <!-- 除權名單 -->
                                <thead>
                                    <tr>
                                        <th>id_D</th>
                                        <th>emp_id</th>
                                        <th>user</th>
                                        <th>cName</th>
                                        <th>Site_id</th>
                                        <th>Area_id</th>
                                        <th>Fab_id</th>
                                        <th>sys_id</th>
                                        <th>role</th>
                                        <th>idty</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                    if(!empty($unenrolleds)){

                                        foreach($unenrolleds as $unenrolled){ 
                                            echo '<tr>';
                                                echo '<td title="created_at："'.$unenrolled["created_at"].'">'.$unenrolled["id"].'</td>';
                                                echo '<td>'.$unenrolled["emp_id"].'</td>';
                                                echo '<td>'.$unenrolled["user"].'</td>';
                                                echo '<td>'.$unenrolled["cname"].'</td>';
                                                echo '<td title="'.$unenrolled["s_remark"].'">'.$unenrolled["site_title"].'</td>';
                                                echo '<td title="'.$unenrolled["a_remark"].'">'.$unenrolled["area_title"].'</td>';
                                                echo '<td title="'.$unenrolled["f_remark"].'">'.$unenrolled["fab_title"].'</td>';
                                                echo '<td>'.$unenrolled["sys_id"].'</td>';
                                                $styleNew = styleIdentify($unenrolled);
                                                echo '<td style="'.$styleNew["role_id"].'">';
                                                    echo '<span class="roleColor" >【'.$unenrolled["role_id"] .'】</span>'.$unenrolled["role_title"];
                                                echo '</td>';
                                                echo '<td style="'.$styleNew["idty_id"].'">';
                                                    echo $unenrolled["idty_title"];
                                                echo '</td>';
                                                echo '<td><a href="edit.php?id='.$unenrolled["id"].'" class="btn btn-sm btn-xs btn-info" title="編輯資料" ><i class="bi bi-brush"></i></a></td>';
                                            echo '</tr>';
                                        }
                                    } else{
                                        echo '<tr>'; 
                                            echo '<td colspan="11">無資料</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 彈出畫面模組_該部分為新增 -->
    <div class="modal fade" id="add_url" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">新增user</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body p-4">
                        <div class="row mb-0">
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">user ID：</label><sup class="text-danger"> *</sup>
                                <input type="text" name="user" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">Password：</label>
                                <input type="password" name="pw" id="iconpassword" class="form-control">
                                <input type="checkbox" onclick="cbshow()"> 顯示密碼
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">emp_id/工號：</label><sup class="text-danger"> *</sup>
                                <input type="text" name="emp_id" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">中文姓名：</label><sup class="text-danger"> *</sup>
                                <input type="text" name="cname" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">site_id：</label><sup class="text-danger"> *</sup>
                                <select name="site_id" id="site_id" class="form-select" required >
                                    <option value="" for="site_id" >--請選擇地區--</option>
                                    <?php foreach($sites as $site){ ?>
                                        <option value="<?php echo $site["id"];?>"><?php echo $site["id"];?>: <?php echo $site["site_title"];?> (<?php echo $site["remark"];?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">area_id：</label><sup class="text-danger"> *</sup>
                                <select name="area_id" id="area_id" class="form-select" required >
                                    <option value="" for="area_id" >--請選擇廠區--</option>
                                    <?php 
                                        foreach($areas as $area){ 
                                            if($area['id'] == 0 && $member["role_id"] > 1){
                                                continue;
                                            }
                                            $areaSelected = $area["id"] === $user["area_id"]?'selected':'';
                                        
                                            echo '<option value="'.$area["id"].'" '.$areaSelected.'>';
                                            echo $area["id"].': '.$area["area_title"].' ('.$area["remark"].')</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">fab_id：</label><sup class="text-danger"> *</sup>
                                <select name="fab_id" id="fab_id" class="form-select" required disabled>
                                    <option value="" for="fab_id" >--請選擇棟別--</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">權限：</label><sup class="text-danger"> *</sup>
                                <select name="role_id" id="role_id" class="form-select" required>
                                    <option value="" for="role_id">--請選擇權限--</option>
                                    <?php foreach($roles as $role){ ?>
                                        <option value="<?php echo $role["id"] ?>" for="role_id" <?php if($member["role_id"] > 0){ ?> hidden <?php }; ?>><?php echo $role["id"]."_".$role["role_title"]."【".$role["remark"]."】"; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="" class="form-label">職稱：</label><sup class="text-danger"> *</sup>
                                <select name="idty_id" id="idty_id" class="form-select" required>
                                    <option value=""  for="idty_id" >--請選擇選擇職稱--</option>
                                    <?php foreach($idtys as $idty){ 
                                        if($idty["flag"]=="Off"){
                                            continue;
                                        }
                                        ?>
                                        <option value="<?php echo $idty["id"] ?>" for="idty_id" <?php if($member["role_id"] > 0){ ?> hidden <?php }; ?>><?php echo $idty["id"]."_".$idty["idty_title"]."【".$idty["remark"]."】"; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-end">
                            <input type="hidden" value="env_sps" name="sys_id">
                            <input type="submit" value="儲存" name="submit" class="btn btn-primary">
                            <!-- <input type="button" value="取消" class="btn btn-danger" onclick="history.back()"> -->
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function cbshow() {
        var x = document.getElementById("iconpassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    var areaId = document.getElementById("area_id");
    var fabSelect = document.getElementById("fab_id");
    // 定義一個函式來獲取並設置 local 選項
    function fetchFabWithArea(areaId) {
        // 使用 AJAX 或其他方式向後端取得 localWithFabs 數據
        // 以下為示範代碼，請根據您的實際情況進行修改
        $.ajax(
            {
                // 傳輸方式：post；get
                method: "POST",
                // 傳輸網址
                url: "function_ajax.php",
                // 傳輸的資料形式
                dataType:"text",
                // 傳輸的資料
                // 這邊表示，會送出去一個'action'，該'action'的數值為'value'
                data: { 
                    action : areaId
                },
                // 成功了話，執行以下程式
                success: function (post_ajax) {
                    // console.log(post_ajax)
                    var posts = JSON.parse(post_ajax);
                    // 清空下拉選單的選項
                    fabSelect.innerHTML = "";
                    // 添加空白項目
                    var blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "--請選擇棟別--";
                        fabSelect.appendChild(blankOption);
                    // 添加新的選項
                    posts.forEach(function (item) {
                        // console.log(item['local_title'])
                        var option = document.createElement("option");
                        option.value = item['id'];
                        option.text = item['id']+":"+item['fab_title']+" ("+item["remark"]+")";

                        // 判斷是否要選中這個選項
                        if (item['id'] == <?php echo $user["fab_id"]; ?>) {
                            option.selected = true;
                        }
                        fabSelect.appendChild(option);
                    });
                },
                // 載入失敗時的呈現內容
                error: function(){
                    console.log('載入失敗')
                }
        });
    }

    // 監聽選項變化
    areaId.addEventListener("change",function () {
        if (areaId.value !== "") {
            fabSelect.removeAttribute("disabled");
            fetchFabWithArea(areaId.value);
        } else {
            fabSelect.value = "";
            fabSelect.setAttribute("disabled", "disabled");
        }
    });

    // 頁面載入時，初始化顯示選中的選項值和相關 local 選項
    window.addEventListener("load", function () {
        fetchFabWithArea(areaId.value);
    });
</script>
<?php include("../template/footer.php"); ?>