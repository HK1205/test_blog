<?php
setcookie("yourcookie", "diuser", time()-1, "/");
unset($_SESSION['yourauthority']);

$mail = "";
$password = "";
$error = "";

if(isset($_POST['login_btn'])){
    
unset($err_msg); 
$mail = $_POST['mail'];
$password = $_POST['password'];
$err_msg = [];

try {
mb_internal_encoding("utf8");
    
$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$stmt = $pdo->prepare('select mail, AES_DECRYPT(UNHEX(password), \'cryptkey\'), authority from registration where mail =:mail');
$stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);
    
if(!empty($data['AES_DECRYPT(UNHEX(password), \'cryptkey\')']) && ($data['AES_DECRYPT(UNHEX(password), \'cryptkey\')']) == $password){
    session_start();
    $_SESSION['yourauthority'] = $data['authority'];
    setcookie("yourcookie", "diuser", time()+3600, "/");
    header('Location: http://localhost/top/index.html');
    exit();
}else{
    throw new Exception();
}
    
}catch(PDOException $e){
    $error = "エラーが発生したためログイン情報を取得できません。";
}catch(Exception $e){
    $err_msg[0] = "メールアドレスが空白です";
    $err_msg[1] = "メールアドレスが違います";
    $err_msg[2] = "パスワードが空白です";
    $err_msg[3] = "パスワードが違います";
}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="style.css">
 <title>D.I.BLOG LOGIN</title>
</head>
<body>
    <header>
        <img src="./picture/diblog_logo.jpg" width=15% height=15%>
        <div class="navi-bar">
        </div>
    </header>
<main> 
    <?php if($error != ""): ?>
    <font color="red"><h1><?=$error?></h1></font>
    <?php else: ?>
    <div align="center" class="loginframework">
        <h3>ユーザーログイン</h3>
        <form action="" method="post">
            <div>
            <p>メールアドレス　<input type="text" name="mail" value="<?=$mail?>" size="30"></p>
            <?php if(isset($_POST['mail']) && ($_POST['mail']) == ""): ?>
            <font color="red"><?php echo $err_msg[0]; ?></font>
            <?php elseif(!empty($_POST['mail']) && empty($data['AES_DECRYPT(UNHEX(password), \'cryptkey\')'])): ?>
            <font color="red"><?php echo $err_msg[1]; ?></font>
            <?php endif; ?>
            </div>
            <div>
            <p>パスワード　　　<input type="text" name="password" value="<?=$password?>" size="30"></p>
            <?php if(isset($_POST['password']) && ($_POST['password'] == "")): ?>
            <font color="red"><?php echo $err_msg[2]; ?></font>
            <?php elseif((!empty($_POST['password']) && empty($data['AES_DECRYPT(UNHEX(password), \'cryptkey\')']))): ?>
            <font color="red"><?php echo $err_msg[3]; ?></font>
            <?php elseif(isset($_POST['mail']) && ($_POST['mail'] == $data['mail']) && ($data['AES_DECRYPT(UNHEX(password), \'cryptkey\')'] != $_POST['password'])): ?>
            <font color="red"><?php echo $err_msg[3]; ?></font>
            <?php endif; ?>
            </div>
            <div>
            <p><input type="submit" name="login_btn" value="ログイン"></p>
            </div>
        </form>
    </div>
    <?php endif; ?>
    
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>