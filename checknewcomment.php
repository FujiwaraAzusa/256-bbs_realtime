<?php
session_start();
require_once 'dbconnect.php';
ini_set("display_errors", 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// セッションにログイン情報がない場合はログインページにリダイレクト
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$threadName = $_POST["threadName"];
$commentCount = $_POST["count"];
//スレッド内部の書き込み総数を取得
$sql = "SELECT COUNT(*) as row_count FROM thread_{$_POST['thread']}";
$result = $dbh->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $commentCount = $row["row_count"];
}

if ($_POST['count'] > $commentCount) {
    //新規コメントの内容をjsonで古い順に送信
    echo json_encode($response);
} else {
    //0を返す
    $response['dataArray'] = array("no");
    echo json_encode($response);
}

?>