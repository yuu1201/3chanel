<?php
//mysqlに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
//テーブルを作成
$sql="CREATE TABLE tb4"
."("
."id int NOT NULL AUTO_INCREMENT,"//投稿番号
."name0 char(32),"//名前
."comment0 TEXT,"//コメント
."pass0 char(32),"//パスワード
."date0 DATETIME,"//日付
."PRIMARY KEY(id)"//投稿番号を被らないようにする
.");";
$stmt=$pdo->query($sql);
//テーブルが作成されているかチェック
/*$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
 echo $row[0];
 echo '<br>';
}
echo "<hr>";
*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>3ちゃんねる</title>
</head>
<body>
<h1>3ちゃんねる</h1>
<form action="mission_2-15.php" method="post">
<input type="submit" value="更新">
</form>
<hr size='5' color='black'>
<?php
//名前の取得
$name=$_POST['name'];
//コメントの取得
$comment=$_POST['comment'];
//パスワードの取得
$pass=$_POST['password'];
//削除対象番号の取得
$delete=$_POST['delete'];
//パスワードの取得
$deletepass=$_POST['deletepass'];
//編集対象番号の取得
$edit=$_POST['edit'];
$edit2=$_POST['hidden'];
//echo $edit2;
//パスワードの取得
$editpass=$_POST['editpass'];
//空の定義
$b=!empty($name);
$c=!empty($comment);
$d=!empty($pass);
//空でないときのみ書き込み
//削除の処理
//check1
//echo "check1".$delete."<br>";
//空の定義
$e=!empty($edit);
//テーブルから受け取る。
$sql='SELECT*FROM tb4';
$results=$pdo->query($sql);
//編集対象番号が空でないときのみ作動
if($e){
//繰り返し処置
foreach($results as $k){
//編集番号と一致するものだけ配列を書き換え
if($edit==$k['id'] and $editpass==$k['pass0']){
$m=$k;
}
};
}
?>
<h2>コメント投稿フォーム</h2>
<form action="mission_2-15.php" method="post">
<label for="name_label">
名前
</label><br>
<input type="text" name="name" size="15" value="<?php echo $m['name0']; ?>"><br>
<label for="comment_label">
コメント
</label><br>
<input type="text" name="comment" size="30" value="<?php echo $m['comment0']; ?>"> 
<input type="hidden" name="hidden" value="<?php echo $edit; ?>"><br>
<label for="password_label">
パスワード
</label><br>
<input type="password" name="password" size="15" value="<?php echo $m['pass0']; ?>"><br>
<input type="submit" value="送信"/>
</form>
<?php
//名前、コメント、パスワードのいずれかが空のときの処置
if(empty($name) and empty($comment) and empty($pass)){
}else{
if(!empty($name) and !empty($comment) and !empty($pass)){
}else{
echo "名前、コメント、パスワードのいずれかが入力されていません";
}
}
?>
<hr size='5' color='black'>
<h2>コメント編集フォーム</h2>
<form action="mission_2-15.php" method="post">
<label for="delete_label">
削除対象番号
</label><br>
<input type="text" name="delete" size="5"><br>
<label for="deletepass_label">
パスワード
</label><br>
<input type="password" name="deletepass" size="15"><br>
<input type="submit" value="削除"><br>
</form>
<?php
//ここから削除の措置
//削除番号が空でないときのみ作動
if(!empty($delete)){
//テーブルから受け取る
$sql='SELECT*FROM tb4';
$results=$pdo->query($sql);
//check2
//echo "check2"."<br>";
//print_r($file)."<br>";
//繰り返し
foreach($results as $g){
//編集番号とパスワードが一致するときのみ作動
if($delete ==$g['id']  and $deletepass ==$g['pass0']){
$id=$delete;
//テーブルから削除
$sql="delete from tb4 where id=$id";
$results=$pdo->query($sql);
}
//パスワードが間違っているときの措置
if($delete==$g['id'] and $deletepass !=$g['pass0']){
echo "パスワードが間違っています";
}
};
}
//番号の振り直し
//テーブルからidカラムを削除
$sql="ALTER TABLE tb4 DROP id";
$result=$pdo->query($sql);
/*echo 'check1'."<br>";
$sql='SHOW CREATE TABLE tb4';
$result=$pdo->query($sql);
foreach($result as $row){
 print_r($row);
}*/
//新しくカラムを作成
$sql="ALTER TABLE tb4 add id int primary key not null auto_increment first";
$result=$pdo->query($sql);
/*echo 'check2'."<br>";
$sql='SHOW CREATE TABLE tb4';
$result=$pdo->query($sql);
foreach($result as $row){
 print_r($row);
}*/
//振り直し番号を1からとする
$sql="ALTER TABLE tb4 AUTO_INCREMENT =1";
$result=$pdo->query($sql);
/*echo 'check3'."<br>";
$sql='SHOW CREATE TABLE tb4';
$result=$pdo->query($sql);
foreach($result as $row){
 print_r($row);
}*/
?>
<hr>
<form action="mission_2-15.php" method="post">
<label for="edit_label">
編集対象番号
</label><br>
<input type="text" name="edit" size="5"><br>
<label for="editpass_label">
パスワード
</label><br>
<input type="password" name="editpass" size="15"><br>
<input type="submit" value="編集">
</form>
<?php
if($b and $c and $d){
//書き込みの場合と編集の場合の区別
//編集の場合
if(!empty($edit2)){
//echo "check";
$sql='SELECT*FROM tb4';
$result=$pdo->query($sql);
//テーブルの中身を書き換え
$id=$edit2; $nm=$name; $kome=$comment; $pss=$pass; $dte=date('Y-m-d H:i:s');
$sql="update tb4 set name0='$nm',comment0='$kome' ,pass0='$pss',date0='$dte' where id=$id";
$result=$pdo->query($sql);
}
//書き込みの場合
else{
//テーブルに書き込み
//INSERT文で書き込み
$sql=$pdo->prepare("INSERT INTO tb4(name0,comment0,pass0,date0)VALUES(:name0,:comment0,:pass0,:date0)");
$sql->bindParam(':name0',$name0,PDO::PARAM_STR);//名前
$sql->bindParam(':comment0',$comment0,PDO::PARAM_STR);//コメント
$sql->bindParam(':pass0',$pass0,PDO::PARAM_STR);//パスワード
$sql->bindParam(':date0',$date0,PDO::PARAM_STR);//日付
//書き込む内容を入力フォームから受け取ったものに指定
$name0=$name;
$comment0=$comment;
$pass0=$pass;
$date0=date('Y/m/d H:i:s');
$sql->execute();
}
}
$e=!empty($edit);
//編集対象番号が空でないときのみ作動
if($e){
//テーブルから読み取り
$sql='SELECT*FROM tb4';
$results=$pdo->query($sql);
//繰り返し処置
foreach($results as $k){
if($edit==$k['id']and $editpass==$k['pass0']){
}
//パスワードが間違っているときの措置
elseif($edit==$k['id']and$editpass!=$k['pass0']){
$edit=null;
echo "パスワードが間違っています";
}
};
}
?>
<hr size='8' color='black'>
<?php
//最後にテーブルから受け取りブラウザに出力
$sql='SELECT*FROM tb4';
$results=$pdo->query($sql);
foreach($results as $row){
echo "[";
echo $row['id'];
echo "]";
echo  $row['name0'];
echo "(";
echo  $row['date0'];
echo ")"."<br>"."<hr>";
echo $row['comment0']."<br>"."<hr size='3' color='black'>";
}
?>
</body>
</html>