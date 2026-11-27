<?php 
// 2023.04.18_修改為此ERT的版本。
?>
<?php 
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");

include("../template/nav.php");


if(!isset($member["id"])){
    $user = $_SESSION["AUTH"]["user"];
    $empId = $_SESSION["AUTH"]["emp_id"];
    $cname = $_SESSION["AUTH"]["cname"];
    $siteM = $_SESSION[$sys_id]["site_title"];
    $areaM = $_SESSION[$sys_id]["area_title"];
    $fabM = $_SESSION[$sys_id]["fab_title"];
    $bPass = false;

}else{
    $user = $member["user"];
    $empId = $member["emp_id"];
    $cname = $member["cname"];
    $siteM = $member["site_title"];
    $areaM = $member["area_title"];
    $fabM = $member["fab_title"];
    $bPass = true;
}


?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 bg-light border p-4 rounded my-2">
            <div class="row">
                <div class="col-12">
                    <h4 id="colorful">建立User資訊</h4>
                </div>
            </div>
            <hr>
            <form action="store.php" method="post" enctype="multipart/form-data" 
                onsubmit="
                this.user.disabled=false,
                    this.role_id.disabled=false, this.cname.disabled=false, this.emp_id.disabled=false,
                    this.site_id.disabled=false, this.sys_id.disabled=false, this.idty_id.disabled=false"
                >
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">user ID/帳號：<sup class="text-danger">*</sup></label>
                        <input type="text" name="user" class="form-control" required value="<?php echo $user;?>" readonly>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">Password/密碼：(NT帳號請勿設定密碼)</label>
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">emp_id/工號：<sup class="text-danger">*</sup></label>
                        <input type="text" name="emp_id" id="emp_id" class="form-control" required value="<?php echo $empId;?>">
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="" class="form-label">中文姓名：<sup class="text-danger">*</sup></label>
                        <input type="text" name="cname" id="cname" class="form-control" required value="<?php echo $cname;?>">
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="site_id" class="form-label">site_region：<sup class="text-danger">*</sup></label>
                        <select name="site_id" id="site_id" class="form-control" required >
                            <option value="" for="site_id">--請選擇地區--</option>
                            <?php 
                            foreach($sites as $site){ 
                                $siteSelect = (isset($siteM) && $site['site_title'] == $siteM)? 'selected': '';
                                echo '<option value="'.$site["id"].'" '.$siteSelect.' >'.$site["id"].':'.$site["site_title"].' ('.$site["remark"].')</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="area_id" class="form-label">plant_area：<sup class="text-danger">*</sup></label>
                        <select name="area_id" id="area_id" class="form-control" required >
                            <option value="" for="area_id">--請選擇廠區--</option>
                            <?php 
                            foreach($areas as $area){ 
                                if($area['id'] == 0){
                                    continue;
                                }
                                $areaSelect = (isset($areaM) && $area['area_title'] == $areaM)? 'selected': '';
                                echo '<option value="'.$area["id"].'" '.$areaSelect.' >';
                                echo $area["id"].': '.$area["area_title"].' ('.$area["remark"].')</option>';
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="fab_id" class="form-label">fab_building：<sup class="text-danger">*</sup></label>
                        <select name="fab_id" id="fab_id" class="form-control" required >
                            <option value="" for="fab_id">--請選擇棟別--</option>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="role_id" class="form-label">role/權限：<sup class="text-danger"> - disabled </sup></label>
                        <select name="role_id" id="role_id" class="form-select" disabled>
                            <option value="" for="role_id">--請選擇權限--</option>
                            <?php foreach($roles as $role){ 
                                if($role["id"]=="5"){
                                echo '<option value="'.$role["id"].'" for="role_id" selected >'.$role["id"].'_'.$role["role_title"].'【'.$role["remark"].'】'.'</option>';
                            }}?>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="idty_id" class="form-label">職稱：<sup class="text-danger"> - disabled </sup></label>
                        <select name="idty_id" id="idty_id" class="form-select" disabled>
                            <option value=""  for="idty_id" >--請選擇選擇職稱--</option>
                            <?php foreach($idtys as $idty){ 
                                if($idty["id"]=="5"){
                                    echo '<option value="'.$idty["id"].'" for="idty_id" selected >'.$idty["id"].'_'.$idty["idty_title"].'【'.$idty["remark"].'】'.'</option>';
                                }
                                ?>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <input type="hidden" value="env_sps" name="sys_id">
                    <input type="hidden" value="<?php echo $bPass;?>" name="bPass">
                    <input type="submit" value="儲存" name="submit" class="btn btn-primary">
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
    console.log(areaId);
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