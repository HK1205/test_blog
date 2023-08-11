<?php
session_start();
mb_internal_encoding("utf8");
$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$pdo->exec("insert into contactform(name,mail,age,comment) values ('".$_POST['name']."','".$_POST['mail']."','".$_POST['age']."','".$_POST['comment']."');");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
    <header>
        <img src="./picture/diblog_logo.jpg" width=15% height=15%>
        <div class="navi-bar">
            <ul>
                <li onClick="location.href='http://localhost/top/index.html'">トップ</li>
                <li>プロフィール</li>
                <li>D.I.Blogについて</li>
                <li onClick="location.href='http://localhost/diworks_keijiban/index.php'">掲示板</li>
                <?php if($_SESSION['yourauthority'] == 1): ?>
                <li onClick="location.href='http://localhost/account_registration/regist.php'">アカウント登録</li>
                <li onClick="location.href='http://localhost/accounts/list.php'">アカウント一覧</li>
                <?php endif; ?>
                <li onClick="location.href='http://localhost/contactform/index.php'">お問い合わせ</li>
                <li>その他</li>
            </ul>
        </div>
    </header>
    <main>
    <div class="bg">
    <div class="confirm">
        <p>お問い合わせありがとうございました。
            <br>3営業日以内に担当者よりご連絡差し上げます。
        </p>
    </div>
    </div>
    </main>
    <footer>
    Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>
</body>
</html>