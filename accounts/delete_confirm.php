<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try{
    
    session_start();
    
    if($_SESSION['yourauthority'] == 0){
        throw new Exception();
    }
    
}catch(Exception $e){
    $e = "不正なアクセスを検出しました";
}
    
}else{
        header('Location: http://localhost/userlogin/login.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="CSS/confirm.css">
 <title>D.I.BLOG</title>
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
    <?php if($_SESSION['yourauthority'] == 1): ?>
    <div align="center">
    <h2>アカウント削除確認画面</h2>
    </div>
    <div align="center">
    <h1>本当に削除してよろしいでしょうか？</h1>
    </div>
    <div align="center">
    <button onClick="location.href='http://localhost/accounts/delete.php'">前に戻る</button>
    <button onClick="location.href='http://localhost/accounts/delete_complete.php'">削除する</button>
    </div>
    <?php else:?>
    <h1><font color="red"><?php echo $e; ?></font></h1>
    <?php endif; ?>
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>