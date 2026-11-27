<?php
// 版本履歷：
// 2023.05.18
// 1.加入防止重複載入權限的措施。2.加入權限判斷機制。

?>
<?php
    require_once("../pdo.php");
    require_once("../functionAuth.php");
    require_once("../functionHome.php");
    require_once("function.php");

    accessDenied_sys($sys_id);
    // 判斷權限。
    accessDeniedAssistant($sys_id);

    if(isset($_POST["submit"])){
        storeArea($_REQUEST);
    }

    // 統合到functionHome
    // $areas = showArea();
    // <!-- 20211215分頁工具 -->
    $rs = $areas;
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

    $div_areas = page_div($start,$per);
        // $rs = page_div($start,$per);
        $page_start = $start +1;  //選取頁的起始筆數
        $page_end = $start + $per;  //選取頁的最後筆數
        if($page_end>$per_total){  //最後頁的最後筆數=總筆數
            $page_end = $per_total;
        }
    // <!-- 20211215分頁工具 -->

?>
<?php 
    include("../template/header.php");
    include("../template/nav.php");
    // 共同CSS設置
    include("../template/commonCss.php");
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
                    <h3 class="colorfulH3">Area_Administration</h3>
                </div>

            </div>
            <!-- <hr> -->
            <div class="col-12 justify-content-center rounded bg-light px-4">
                <div class="col-12">
                    <!-- 20211215分頁工具 -->               
                    <div class="row">
                        <div class="text-end" style="margin-bottom: 5px;">
                        <?php if($member["role_id"] == 0){ ?>
                            <a href="#" target="_blank" title="廠區for新增" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_area"><i class="bi bi-plus-circle"></i></a>
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
                    <table>
                        <thead>
                            <tr class="">
                                <th style="">ai</th>
                                <th style="">area</th>
                                <th style="">remark</th>
                                <th style="">flag</th>
                                <!-- <th style="">user_id</th> -->
                                <!-- <th style="">created_at</th> -->
                                <th style="">updated_at <i class="fa fa-info-circle" aria-hidden="true"></i></th>
                                <?php if($member["role_id"] == 0){ ?>    
                                    <th style="">action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <!-- 這裡開始抓SQL裡的紀錄來這裡放上 -->
                        <tbody>
                            <?php foreach($div_areas as $area){ ?>
                                <tr>
                                    <td style=""><?php echo $area['id']; ?></td>
                                    <td style=""><?php echo $area['area_title']; ?></td>
                                    <td style=""><?php echo $area['remark']; ?></td>
                                    <td <?php if($area["flag"] == 'Off'){ ?> style="background-color:yellow" <?php } ?>><?php echo $area['flag']; ?></td>
                                    <!-- <td style=""><?php echo $area['cname']; ?></td> -->
                                    <!-- <td style="font-size: 6px;"><?php echo $area['created_at']; ?></td> -->
                                    <td style="" title="最後編輯: <?php echo $area['cname']; ?>"><?php echo $area['updated_at']; ?></td>
                                    <?php if($member["role_id"] == 0){ ?>    
                                        <td style="">
                                            <a href="edit.php?id=<?php echo $area['id'];?>" class="btn btn-sm btn-xs btn-info" title="編輯資料"><i class="bi bi-brush"></i></a>
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
<div class="modal fade" id="add_area" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">新增Area</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="store.php" method="post" onsubmit="this.owner.disabled=false">
                <div class="modal-body px-5">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-label">area/名稱：</label>
                            <input type="text" name="area_title" class="form-control" required placeholder="area名稱">
                        </div>
                        <div class="col-12">
                            <label for="" class="form-label">remark/註解說明：</label>
                            <input type="text" name="remark" class="form-control" required placeholder="註解說明">
                        </div>
                        <div class="col-12">
                            <label for="flag" class="form-label">flag/顯示開關：</label></br>
                            <input type="radio" name="flag" value="On" id="On" class="form-check-input" checked>
                            <label for="On" class="form-check-label">On</label>
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

<?php include("../template/footer.php"); ?>