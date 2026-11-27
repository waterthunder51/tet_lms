<?php
// 版本資訊
// 2023.11.29_導入Hr資料庫，大量相關邏輯進行修正。

?>
<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    // 避免重複載入加的措施。
    if (!isset($_SESSION)) {
        session_start();
    }
    // 判斷權限。
    accessDeniedAssistant($sys_id);
    // edit頁面導入id使用。
    $fabEdite = editFab($_REQUEST);
    // $sites = siteList();
    // $areas = areaList();
    
    if(isset($_POST["delete"])){
        deleteFab($_REQUEST);
        header("refresh:0;url=../fab/index.php");
    }

    include("../template/nav.php");

?>

<style>

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 bg-light border p-4 rounded my-2">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h4>編輯『
                    <span id ="colorful" ><?php echo $fabEdite["fab_title"] ?></span>
                    』Fab資訊
                    </h4>
                </div> 
                <div class="col-12 col-md-4 text-end">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $fabEdite["id"];?>">
                        <input type="submit" name="delete" id="delete" value="&#xF2E6;" title="刪除Fab" class="btn btn-danger" onclick="return confirm('確認刪除？')">
                    </form>
                </div> 
            </div>
            <hr>
            <form action="update.php" method="post">
                <div class="row px-3">
                    <div class="mb-3">
                        <label for="" class="form-label">site/區域：</label>
                        <select class="form-select" name="site_id" aria-label="Default select example">
                        <?php foreach( $sites as $site ){ ?>
                            <option value="<?php echo $site['id'];?>" <?php if( $site['id'] == $fabEdite["site_id"]){ echo "selected"; } ?>><?php echo $site['site_title']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">area/廠區：</label>
                        <select class="form-select" name="area_id" aria-label="Default select example">
                        <?php foreach( $areas as $area ){ ?>
                            <option value="<?php echo $area['id'];?>" <?php if( $area['id'] == $fabEdite["area_id"]){ echo "selected"; } ?>><?php echo $area['area_title']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">fab_title/棟別名稱：</label>
                        <input type="text" name="fab_title" class="form-control" required placeholder="fab名稱" value="<?php echo $fabEdite["fab_title"];?>" onblur="convertToUpperCase(this)">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">fab_hr/人事資料棟別：</label>
                        <input type="text" name="fab_hr" class="form-control" required placeholder="人事資料棟別" value="<?php echo $fabEdite["fab_hr"];?>" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">remark/備註說明：</label>
                        <input type="text" name="remark" class="form-control" required placeholder="備註說明" value="<?php echo $fabEdite["remark"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">local_connect/相關廠別：</label>
                        <input type="text" name="local_connect" id="local_connect" class="form-control" placeholder="相關廠別" value="<?php echo $fabEdite["local_connect"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="flag" class="form-label">flag/顯示開關：</label></br>
                        <input type="radio" name="flag" value="On" id="On" class="form-check-input" <?php echo $fabEdite["flag"] == "On" ? "checked":""; ?>>
                        <label for="On" class="form-check-label">On</label>&nbsp&nbsp
                        <input type="radio" name="flag" value="Off" id="Off" class="form-check-input" <?php echo $fabEdite["flag"] == "Off" ? "checked":""; ?>>
                        <label for="Off" class="form-check-label">Off</label>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <input type="hidden" value="<?php echo $fabEdite["id"];?>" name="id">
                    <input type="hidden" value="<?php echo $member["id"];?>" name="user_id">
                    <input type="submit" value="儲存" name="submit" class="btn btn-primary">
                    <input type="button" value="取消" class="btn btn-danger" onclick="history.back()">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // 限制輸入的英文字母必為大寫。
    function convertToUpperCase(inputElement) {
        var inputValue = inputElement.value;
        var upperCaseValue = inputValue.toUpperCase();
        inputElement.value = upperCaseValue;
    }
</script>
<?php include("../template/footer.php"); ?>