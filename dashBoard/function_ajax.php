<?php
// 以下為接收ajax並回拋結果
// 導入資料庫
require_once("../pdo.php");
// for 觸發互動式窗按鈕edit頁面使用。
// 導入JSon的系統語言，利於回傳使用
header('Content-Type: application/json; charset=utf-8');
// IF接收到post的'acton'。
if(isset($_POST['action'])){
    // 定義action，利於後面的SQL取用。
    $action = $_POST['action'];
    // 建立一個'function'利於後續的每次'要求'達成。
    function ajaxPost($request){
        $pdo = pdo();
        extract($request);
        $sql2 = "SELECT posts.*,lists.id AS s_id,lists.name,categories.id AS c_id,categories.title,fabs.id AS f_id,fabs.fab_title
                FROM posts
                LEFT JOIN categories ON posts.category_id = categories.id
                LEFT JOIN lists ON posts.list_id = lists.id 
                LEFT JOIN fabs ON posts.fab_id = fabs.id
                WHERE posts.list_id = $action 
                ORDER BY fab_id ";
        $stmt2 = $pdo->prepare($sql2);
        try {
            $stmt2->execute();
            $posts = $stmt2->fetchAll();
            return $posts;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    // 以下為ajax回傳重點
    // 定義一個變數為上方程式，帶入'要求'(aka $_REQUEST)後產生的結果。
    // 幾點小備註：
    // 1.function需要用return才回成立。故，純粹使用'print_r'是無法'打印'出東西的。
    // 2.如果去除function與return，會導致無'要求'(aka $_REQUEST)，而無法達成點擊後，資料更著轉變。
    $post_ajax = ajaxPost($_REQUEST);
    // 使用print_r將資料回饋，由於回饋資料需要員需求頁面接受，故使用'json_encode'將資料改為JSON格式。
    // 如果回傳非使用JSON，則實際上回傳為'String'，非'Array'。會導致後續無法使用。
    print_r(json_encode($post_ajax));
    // 以下部分為終止此段程式進行。否則程式將會往下進行導致執行後續程式。
    return $action;
}


// IF接收到post的'action1'。
if(isset($_POST['action1'])){
    // 定義action1，利於後面的SQL取用。
    $action1 = $_POST['action1'];
    // 建立一個'function'利於後續的每次'要求'達成。
    function ajaxList($request){
        $pdo = pdo();
        extract($request);
        $sql = "SELECT lists.*,categories.id AS c_id,categories.title
                FROM lists
                LEFT JOIN categories ON lists.category_id = categories.id
                WHERE lists.id = $action1 ";
        $stmt1 = $pdo->prepare($sql);
        try {
            $stmt1->execute();
            $lists = $stmt1->fetchAll();
            return $lists;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    // 以下為ajax回傳重點
    $list_ajax = ajaxList($_REQUEST);
    print_r(json_encode($list_ajax));
    return $action1;
}

?>
    