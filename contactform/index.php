<?php
session_start();

$AgeList = Array(
    "18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51",
    "52","53","54","55","56","57","58","59","60","61","62","63","64","65"
);

    
if(isset($_POST["back"])){
    
$name = $_SESSION['name'];
$mail = $_SESSION['mail'];
$myage = $_SESSION['age'];
$comment = $_SESSION['comment'];
    
}else{
        
$name = "";
$mail = "";
$comment = "";
    
}

?>
    
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <div class="form">
    <form method="post" action="mail_confirm.php">    
        <h1>お問合わせフォーム </h1>
        <div>
            <label>名前</label><br>
            <input type="text" class="text" size="35" name="name" value="<?=$name?>">
        </div>
        
        <div>
            <label>メールアドレス</label><br>
            <input type="text" class="text" size="35" name="mail" value="<?=$mail?>">            
        </div>
        
        <div>
            <label>年齢</label><br>
            <select class="dropdown" name="age">
             <option>選択してください</option>
                <?php
                foreach($AgeList as $value){
                if(!empty($_POST['age'])){
                if($myage === $value){
                    echo "<option value='$value' selected>".$value."歳</option>";
                }else{
                    echo "<option value='$value'>".$value."歳</option>";
                }
                }else{
                    echo "<option value='$value'>".$value."歳</option>";
                }
                }
                ?>
            </select> 
        </div>
        
        <div>
            <label>お問い合わせ内容</label>
            <br>
            <textarea cols="60" rows="7" name="comment"><?=$comment?></textarea>
        </div>
        <div>
            <input type="submit" name="submit" class="submit" value="送信する">
        </div>
    </form>
    </div>
    </div>
    </main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
    </body>
</html>