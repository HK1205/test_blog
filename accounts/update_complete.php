<?php
mb_internal_encoding("utf8");
$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try {

session_start();
    
if($_SESSION['yourauthority'] == 0){
    throw new PDOException();
}
    
$error = "";
$id = $_SESSION['ID'];
$family_name = $_SESSION['family_name'];
$last_name = $_SESSION['last_name'];
$family_name_kana = $_SESSION['family_name_kana'];
$last_name_kana = $_SESSION['last_name_kana'];
$mail = $_SESSION['mail'];
$password = $_SESSION['password'];
$postal_code = $_SESSION['postal_code'];
$prefecture = $_SESSION['prefecture'];
$address_1 = $_SESSION['address_1'];
$address_2 = $_SESSION['address_2'];
    
if(($_SESSION['gender']) == "男"){
    $gender = 0;
}else if(($_SESSION['gender']) == "女"){
    $gender = 1;
}
    
if(($_SESSION['authority']) == "一般"){
    $authority = 0;
}else if(($_SESSION['authority']) == "管理者"){
    $authority = 1;
}


$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare('update registration set family_name=:family_name, last_name=:last_name, family_name_kana=:family_name_kana, last_name_kana=:last_name_kana, mail=:mail, password=HEX(AES_ENCRYPT(:password, \'cryptkey\')), gender=:gender, postal_code=:postal_code, prefecture=:prefecture, address_1=:address_1, address_2=:address_2, authority=:authority, update_time=now() where id = :id');
$stmt->bindValue(":id", $id, PDO::PARAM_STR);
$stmt->bindValue(":family_name", $family_name, PDO::PARAM_STR);
$stmt->bindValue(":last_name", $last_name, PDO::PARAM_STR);
$stmt->bindValue(":family_name_kana", $family_name_kana, PDO::PARAM_STR);
$stmt->bindValue(":last_name_kana", $last_name_kana, PDO::PARAM_STR);
$stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
$stmt->bindValue(":password", $password, PDO::PARAM_STR);
$stmt->bindValue(":postal_code", $postal_code, PDO::PARAM_INT);
$stmt->bindValue(":prefecture", $prefecture, PDO::PARAM_STR);
$stmt->bindValue(":address_1", $address_1, PDO::PARAM_STR);
$stmt->bindValue(":address_2", $address_2, PDO::PARAM_STR);
$stmt->bindValue(":authority", $authority, PDO::PARAM_INT);
$stmt->bindValue(":gender", $gender, PDO::PARAM_INT);
$stmt->execute();

}catch(PDOException $e){
    $error = "エラーが発生したためアカウント更新できません。";
    $err = "不正なアクセスを検出しました";
}
    
}else{
    header('Location: http://localhost/userlogin/login.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="CSS/complete.css">
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
    <h2>アカウント更新完了画面</h2>   
    <?php
    if($error != ""){
     echo "<div><h1><font color='red'>$error</font></h1></div>";
        
    }else{
        echo "<h1>更新完了いたしました。</h1>";
    }
    ?>
    <button onClick="location.href='http://localhost/top/index.html'">TOPページにもどる</button>
    </div>
    <?php else:?>
    <h1><font color="red"><?php echo $err; ?></font></h1>
    <?php endif; ?>
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>