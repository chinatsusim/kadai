
<!-- お気に入り表示処理 -->
<?php
// 1.  DB接続します
// localhost
try {
$pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
exit('DB_CONNECT:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kadai_02 ORDER BY registDate desc";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
// $view="";
if($status==false) {
//execute（SQL実行時にエラーがある場合）
$error = $stmt->errorInfo();
exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード] //fetchは繰り返しとってくる
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>

<h2>FAVORITE LIST</h2>
<div id="books">
<?php foreach($values as $value){ ?>
    <div class="bookinfo">
        <div><img src="<?=$value["thumbnail"];?>" ?></div>
        <h3><?=$value["title"];?></h3>
        <ul class="bookprofile">
            <li>著者：<?=$value["authors"];?></li>
            <li>出版社：<?=$value["publisher"];?></li>
            <li>出版年：<?=$value["publishedDate"];?></li>
            <li>ISBN：<?=$value["isbn"];?></li>
        </ul>
        <div class="description"><?=$value["description"];?></div>

        <div class="regist-date">登録日：<?=$value["registDate"];?></div>
        <!-- dbからdelete用の値を取得する。 -->
        <form method="POST">
            <input type="hidden" name="isbn" value="<?= $value['isbn']; ?>">
            <button type="submit" class="delete"><span class="material-symbols-outlined">heart_plus</span>DELETE</button>
        </form>
    </div>
    <?php }?>
 </div>