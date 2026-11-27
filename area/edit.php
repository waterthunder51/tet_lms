<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");
    
    // 判斷權限。
    accessDeniedAssistant($sys_id);
    
    $areaEdit = editArea($_REQUEST);
    
    if(isset($_POST["delete"])){
        deleteArea($_REQUEST);
        header("refresh:0;url=index.php");
    }
?>
<?php 
    include("../template/header.php");
    include("../template/nav.php");
    // 共同CSS設置
    include("../template/commonCss.php");
?>
<style>

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 bg-light border p-4 rounded my-2">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h4>編輯『
                        <span id ="colorful" ><?php echo $areaEdit["area_title"] ?></span>
                        』Area資訊
                    </h4>
                </div> 
                <div class="col-12 col-md-5 text-end">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $areaEdit["id"];?>">
                        <input type="submit" name="delete" id="delete" value="&#xF2E6;" title="刪除Area" class="btn btn-danger" onclick="return confirm('確認刪除？')">
                    </form>
                </div> 
            </div>
            <hr>
            <form action="update.php" method="post">
                <div class="row px-3">
                    <div class="mb-3">
                        <label for="" class="form-label">area_title/名稱：</label>
                        <input type="text" name="area_title" class="form-control" required placeholder="area名稱" value="<?php echo $areaEdit["area_title"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">remark/備註說明：</label>
                        <input type="text" name="remark" class="form-control" required placeholder="備註說明" value="<?php echo $areaEdit["remark"];?>">
                    </div>
                    <div class="mb-3">
                        <label for="flag" class="form-label">flag/顯示開關：</label></br>
                        <input type="radio" name="flag" value="On" id="On" class="form-check-input" <?php echo $areaEdit["flag"] == "On" ? "checked":""; ?>>
                        <label for="On" class="form-check-label">On</label>&nbsp&nbsp
                        <input type="radio" name="flag" value="Off" id="Off" class="form-check-input" <?php echo $areaEdit["flag"] == "Off" ? "checked":""; ?>>
                        <label for="Off" class="form-check-label">Off</label>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <input type="hidden" value="<?php echo $areaEdit["id"];?>" name="id">
                    <input type="hidden" value="<?php echo $member["id"];?>" name="user_id">
                    <input type="submit" value="儲存" name="submit" class="btn btn-primary">
                    <input type="button" value="取消" class="btn btn-danger" onclick="history.back()">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../template/footer.php"); ?>