<?php

?>
<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    accessDeniedMember($sys_id);

    $user = editUser($_REQUEST);

include("../template/nav.php");

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 bg-light border p-4 rounded my-2">
            <div class="row">
                <div class="col-12">
                    <h4 id="colorful">編輯User資訊</h4>
                </div>
            </div>
            <hr>
            <form action="update.php" method="post" enctype="multipart/form-data" 
            onsubmit="this.user.disabled=false,
                    this.role_id.disabled=false, this.cname.disabled=false, this.emp_id.disabled=false,
                    this.site_id.disabled=false, this.sys_id.disabled=false, this.idty_id.disabled=false">
                <div class="row px-3">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">user ID/帳號：<?php if($member["role_id"] >= 1){ ?><sup class="text-danger"> - disabled </sup><?php } ?></label>
                        <!-- <h3 class="outline: none;"><?php echo $user["user"];?></h3> -->
                        <input type="text" name="user" class="form-control" value="<?php echo $user["user"];?>" <?php if($member["role_id"] >= 1){ ?>readonly <?php } ?>>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">Password/密碼：(NT帳號請勿設定密碼)</label>
                        <input type="password" name="pw" id="iconpassword" class="form-control" value="" placeholder="未設定新密碼，自動沿用舊密碼">
                        <input type="checkbox" onclick="cbshow()"> 顯示密碼
                        <!-- <input type="checkbox" name="resetPw" value="resetPw" onclick="resetPw()"> 清除密碼 -->
                        <input type="checkbox" onclick="resetPw()" name="resetPw" value="true"> 清除密碼
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">emp_id/工號：<?php if($member["role_id"] > 0){ ?><sup class="text-danger"> - disabled </sup><?php } ?></label>
                        <input type="text" name="emp_id" class="form-control" value="<?php echo $user["emp_id"];?>" <?php if($member["role_id"] > 0){ ?>readonly <?php } ?>>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">中文姓名：<?php if($member["role_id"] > 0){ ?><sup class="text-danger"> - disabled </sup><?php } ?></label>
                        <input type="text" name="cname" class="form-control" value="<?php echo $user["cname"];?>" <?php if($member["role_id"] > 0){ ?>readonly <?php } ?>>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="site_id" class="form-label">site_region：<sup class="text-danger">*</sup></label>
                        <select name="site_id" id="site_id" class="form-select" required >
                            <option value="" for="site_id">--請選擇地區--</option>
                            <?php
                            foreach($sites as $site){ 
                                $siteSelected = $site["id"] === $user["site_id"]?'selected':'';
                                echo '<option value="'.$site["id"].'" '.$siteSelected.'>';
                                echo $site["id"].': '.$site["site_title"].' ('.$site["remark"].')</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="area_id" class="form-label">plant_area：<sup class="text-danger">*</sup></label>
                        <select name="area_id" id="area_id" class="form-select" required >
                            <option value="" for="area_id">--請選擇廠區--</option>
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
                    <div class="mb-3 col-12 col-md-6">
                        <label for="fab_id" class="form-label">fab_building：<sup class="text-danger">*</sup></label>
                        <select name="fab_id" id="fab_id" class="form-select" required disabled >
                            <option value="" for="fab_id">--請選擇棟別--</option>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="role_id" class="form-label">role：<?php if($member["role_id"] > 1){ ?><sup class="text-danger"> - disabled </sup><?php } ?></label>
                        <select name="role_id" id="role_id" class="form-select" <?php if($member["role_id"] > 1){ echo "disabled"; } ?>>
                            <option value="" for="role_id">--請選擇權限--</option>    
                            <?php foreach($roles as $role){ ?>
                                <option value="<?php echo $role["id"] ?>" for="role_id" <?php if($user["role_id"] == $role["id"]){ echo "selected"; } ?>><?php echo $role["id"]."_".$role["role_title"]."【".$role["remark"]."】"; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="idty_id" class="form-label">idty：<?php if($member["role_id"] > 2){ ?><sup class="text-danger"> - disabled </sup><?php } ?></label>
                        <select name="idty_id" id="idty_id" class="form-select" <?php if($member["role_id"] > 2){ echo "disabled"; } ?>>
                            <option value=""  for="idty_id" >--請選擇選擇職稱--</option>
                            <?php foreach($idtys as $idty){ 
                                if($idty["flag"]=="Off" && $member["role_id"] > 2 ){
                                    continue;
                                }
                                ?>
                                <option value="<?php echo $idty["id"] ?>" for="idty_id" <?php if($user["idty_id"] == $idty["id"]){ echo "selected"; } ?>><?php echo $idty["id"]."_".$idty["idty_title"]."【".$idty["remark"]."】"; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <input type="hidden" value="<?php echo $user["id"];?>" name="id">
                    <input type="hidden" value="env_sps" name="sys_id">
                    <input type="submit" value="儲存" name="submit" class="btn btn-primary">
                    <input type="button" value="取消" class="btn btn-danger" onclick="history.back()">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Checkbox顯示密碼 -->
<script>
    function cbshow() {
        var x = document.getElementById("iconpassword");
        console.log("cbshow");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function resetPw() {
        console.log("resetPw");
        var x = document.getElementById("iconpassword");
            x.value = "";
            x.innerHTML = "";
            // x.reset();
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

    // 定义一个函数来处理 fabSelect 的状态
    function updateFabSelect() {
        if (areaId.value !== "") {
            fabSelect.removeAttribute("disabled");
            fetchFabWithArea(areaId.value);
        } else {
            fabSelect.value = "";
            fabSelect.setAttribute("disabled", "disabled");
        }
    }
    // 所有監聽事件觸發函式
    function attachEventListeners() {
        // 監聽選項變化
        areaId.addEventListener("change", function () {
            updateFabSelect();
        });
    }
    // DOMContentLoaded 事件监听器
    document.addEventListener('DOMContentLoaded', function () {
        updateFabSelect();
        // 绑定事件监听器
        attachEventListeners();
    });
</script>
<?php include("../template/footer.php"); ?>