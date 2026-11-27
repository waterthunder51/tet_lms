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

    // 先判斷是否存在『submit』這個活動。
    // 如果有接受到，則將data丟給storeCategory跑後續。
    if(isset($_POST["submit"])){
        accessDeniedAdmin($sys_id);
        storeFab($_REQUEST);
    }
    
    // 先判斷是否存在『delete』這個活動。
    // 如果有接受到，則將data丟給deleteCategory跑後續。
    if(isset($_POST["delete"])){
        accessDeniedAdmin($sys_id);
        deleteFab($_REQUEST);
    }

    // show各categories的list。(統合到functionHome)
    // $fabs = fabList();
    // $sites = siteList();
    // $areas = areaList();
    $i = 0;

    // <!-- 20211215分頁工具 -->
    $rs = $fabs;
        //分頁設定
        // $per_total = $rs -> rowCount();  //計算總筆數
        $per_total = count($rs);  //計算總筆數
        $per = 50;  //每頁筆數
        $pages = ceil($per_total/$per);  //計算總頁數;ceil(x)取>=x的整數,也就是小數無條件進1法
        if(!isset($_GET['page'])){  //!isset 判斷有沒有$_GET['page']這個變數
            $page = 1;	  
        }else{
            $page = $_GET['page'];
        }
        $start = ($page-1)*$per;  //每一頁開始的資料序號(資料庫序號是從0開始)

    $div_fabs = page_div($start,$per);
        // $rs = page_div($start,$per);
        $page_start = $start +1;  //選取頁的起始筆數
        $page_end = $start + $per;  //選取頁的最後筆數
        if($page_end>$per_total){  //最後頁的最後筆數=總筆數
            $page_end = $per_total;
        }
    // <!-- 20211215分頁工具 -->

    include("../template/nav.php");

?>
<html lang="zh-TW">
<style>

</style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row" style="vertical-align:bottom;">
                    <div class="col-12">
                        <h3 class="colorfulH3">Fab_Administration</h3>
                    </div>

                </div>
                <!-- <hr> -->
                <div class="col-12 justify-content-center rounded bg-light px-4">
                    <div class="col-12">
                        <!-- 20211215分頁工具 -->
                        <div class="row">
                            <div class="text-end" style="margin-bottom: 5px;">
                            <?php if($member["role_id"] == 0){ ?>
                                <a href="#" target="_blank" title="廠別for新增" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_fab"><i class="bi bi-plus-circle"></i></a>
                            <?php } ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <?php
                                //每頁顯示筆數明細
                                echo '顯示 '.$page_start.' 到 '.$page_end.' 筆 共 '.$per_total.' 筆，目前在第 '.$page.' 頁 共 '.$pages.' 頁'; 
                                ?>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                            <?php
                            if ($pages > 1) { //總頁數>1才顯示分頁選單
                                // 添加省略号
                                $ellipsis = '...';
                            
                                //分頁頁碼；在第一頁時,該頁就不超連結,可連結就送出$_GET['page']
                                if ($page == '1') {
                                    echo "<i class='bi bi-chevron-bar-left'></i> ";
                                    echo "<i class='bi bi-chevron-double-left'></i> ";
                                } else {
                                    echo "<a href=?page=1><i class='bi bi-chevron-bar-left'></i> </a> ";
                                    echo "<a href=?page=" . ($page - 1) . "><i class='bi bi-chevron-double-left'></i> </a> ";
                                }
                                // 曾加設定首頁與末頁。利於一直顯示超聯接。
                                $startPage = 1;
                                $lastPage = $pages;
                                // 設定如果是首頁，則無超聯接。
                                if($page == $startPage){
                                    echo $startPage. ' ';
                                }else{
                                    echo '<a href=?page=' . $startPage . '>' . $startPage . '</a> ';
                                }
                                //此分頁頁籤以左、右頁數來控制總顯示頁籤數，例如顯示5個分頁數且將當下分頁位於中間，則設2+1+2 即可。若要當下頁位於第1個，則設0+1+4。也就是總合就是要顯示分頁數。如要顯示10頁，則為 4+1+5 或 0+1+9，以此類推。	
                                for ($i = 2; $i < $pages; $i++) {
                                    $lnum = 2; //顯示左分頁數，直接修改就可增減顯示左頁數
                                    $rnum = 2; //顯示右分頁數，直接修改就可增減顯示右頁數
                                    // 設定在首頁的時候，分頁顯示
                                    if ($page == $startPage) {
                                        $rnum = $rnum + 2;
                                    }
                                    // 設定在首頁+1的時候，分頁顯示
                                    if ($page == ($startPage +1 )) {
                                        $rnum = $rnum + 1;
                                    }
                                    // 設定在首頁+2的時候，分頁顯示
                                    if ($page <= ($startPage +2 )) {
                                        $rnum = $rnum - 1;
                                        $lnum = $lnum - 1;
                                        // echo $rnum."-".$lnum;
                                    }
                                
                                    if ($page > ($startPage +2 )) {
                                        $rnum = $rnum - 1;
                                        $lnum = $lnum - 1;
                                        // echo $rnum."-".$lnum;
                                    }
                                    // 設定在末頁-1的時候，分頁顯示
                                    if ($page == ($lastPage -1 )) {
                                        $lnum  = $lnum  + 1;
                                    }
                                    // 設定在末頁的時候，分頁顯示
                                    if ($page == $lastPage) {
                                        $lnum  = $lnum  + 2;
                                    }
                                    //分頁部份處於該頁就不超連結,不是就連結送出$_GET['page']
                                    if ($page - $lnum <= $i && $i <= $page + $rnum) {
                                        if ($i == $page) {
                                            echo $i . ' ';
                                        } else {
                                            echo '<a href=?page=' . $i . '>' . $i . '</a> ';
                                        }
                                    }
                                
                                    // 添加 "1..."
                                    if ($i == $page + $rnum + 1 && $page + $rnum + 1 < $pages) {
                                        echo $ellipsis . ' ';
                                    }
                                
                                    // 添加 "...N"
                                    if ($i == $page - $lnum - 1 && $page - $lnum - 1 > 1) {
                                        echo $ellipsis . ' ';
                                    }
                                }
                                // 設定如果是末頁，則無超聯接。
                                if($page == $lastPage){
                                    echo $lastPage. ' ';
                                }else{
                                    echo '<a href=?page=' . $lastPage . '>' . $lastPage . '</a> ';
                                }
                            
                                //在最後頁時,該頁就不超連結,可連結就送出$_GET['page']	
                                if ($page == $pages) {
                                    echo " <i class='bi bi-chevron-double-right'></i>";
                                    echo " <i class='bi bi-chevron-bar-right'></i>";
                                } else {
                                    echo "<a href=?page=" . ($page + 1) . "> <i class='bi bi-chevron-double-right'></i></a>";
                                    echo "<a href=?page=" . $pages . "> <i class='bi bi-chevron-bar-right'></i></a>";
                                }
                            }
                            ?>
                            </div>
                        </div>
                        <!-- 20211215分頁工具 -->
                        <!-- 正常名單 -->
                        <table>
                            <thead>
                                <tr class="">
                                    <th style="">ai</th>
                                    <th style="">fab_title</th>
                                    <th style="">site</th>
                                    <th style="">area</th>
                                    <th style="">fab_hr</th>
                                    <th style="">remark</th>
                                    <th style="">flag</th>
                                    <!-- <th style="">user_id</th> -->
                                    <!-- <th style="">created_at</th> -->
                                    <th style="">updated_at <i class="fa fa-info-circle" aria-hidden="true"></i></th>
                                    <?php 
                                    if($member["role_id"] == 0){ ?>    
                                        <th style="">action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($div_fabs as $fab){ ?>
                                    <tr>
                                        <td style="" ><?php echo $fab['id']; ?></td>
                                        <td style="" title="相關廠別: <?php echo $fab['local_connect']; ?>"><?php echo $fab['fab_title']; ?></td>
                                        <td style=""><?php echo $fab['site_title']; ?></td>
                                        <td style=""><?php echo $fab['area_title']; ?></td>
                                        <td style=""><?php echo $fab['fab_hr']; ?></td>
                                        <td style=""><?php echo $fab['remark']; ?></td>
                                        <td <?php if($fab["flag"] == 'Off'){ ?> style="background-color:yellow" <?php } ?>><?php echo $fab['flag']; ?></td>
                                        <!-- <td style=""><?php echo $fab['cname']; ?></td> -->
                                        <!-- <td style="font-size: 6px;"><?php echo $fab['created_at']; ?></td> -->
                                        <td style="" title="最後編輯: <?php echo $fab['cname']; ?>"><?php echo $fab['updated_at']; ?></td>
                                        <?php if($member["role_id"] == 0){ ?>    
                                            <td style="">
                                                <a href="edit.php?id=<?php echo $fab['id'];?>" class="btn btn-sm btn-xs btn-info" title="編輯資料"><i class="bi bi-brush"></i></a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- 彈出畫面模組 -->
<div class="modal fade" id="add_fab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- 過長時滾動 -->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">新增Fab</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" onsubmit="this.owner.disabled=false">
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">site/區域：</label>
                                <select class="form-select" name="site_id" aria-label="Default select example">
                                <?php foreach( $sites as $site ){ ?>
                                    <option value="<?php echo $site['id'];?>" ><?php echo $site['site_title']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">area/廠區：</label>
                                <select class="form-select" name="area_id" aria-label="Default select example">
                                <?php foreach( $areas as $area ){ 
                                    if($area["flag"] == "Off"){
                                        continue;
                                    }?>
                                    <option value="<?php echo $area['id'];?>" ><?php echo $area['area_title']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">fab_title/棟別名稱：</label>
                                <input type="text" name="fab_title" class="form-control" required placeholder="fab名稱" onblur="convertToUpperCase(this)">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">fab_hr/人事資料棟別：</label>
                                <input type="text" name="fab_hr" id="fab_hr" class="form-control" placeholder="人事資料棟別">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">remark/備註說明：</label>
                                <textarea name="remark" id="remark" class="form-control" placeholder="備註說明"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">local_connect/相關廠別：</label>
                                <input type="text" name="local_connect" id="local_connect" class="form-control" placeholder="相關廠別">
                            </div>
                            <div class="col-12">
                                <label for="flag" class="form-label">flag/顯示開關：</label></br>
                                <input type="radio" name="flag" value="On" id="On" class="form-check-input" checked>
                                <label for="On" class="form-check-label">On</label>&nbsp&nbsp
                                <input type="radio" name="flag" value="Off" id="Off" class="form-check-input">
                                <label for="Off" class="form-check-label">Off</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-end">
                            <input type="hidden" value="<?php echo $member["id"];?>" name="user_id">
                            <input type="submit" value="新增" name="submit" class="btn btn-primary">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                        </div>
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