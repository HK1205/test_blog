<?php
session_cache_limiter('none');
session_start();

$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try {
    
if($_SESSION['yourauthority'] == 0){
    throw new PDOException();
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
 <link rel="stylesheet" type="text/css" href="CSS/style2.css">
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
                       <table>
                        <tr>
                            <th colspan="2" align="center"><a>アカウント更新確認画面</a></th>
                        </tr>
                        <tr>
                            <td>名前(姓)</td>
                            <td><?php echo $_SESSION['family_name']; ?></td>
                        </tr>
                       
                        <tr>
                            <td>名前(名)</td>
                            <td><?php echo $_SESSION['last_name']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>カナ(姓)</td>
                            <td><?php echo $_SESSION['family_name_kana']; ?></td>
                        </tr>
                   
                        <tr>
                            <td>カナ(名)</td>
                            <td><?php echo $_SESSION['last_name_kana']; ?></td>
                        </tr>
                   

                        <tr>
                            <td>メールアドレス</td>
                            <td><?php echo $_SESSION['mail']; ?></td>
                        </tr>
                   
                        <tr>
                            <td>パスワード</td>
                            <td><?php echo str_repeat('●', strlen($_SESSION['password'])); ?></td>
                        </tr>
                   
                        <tr>
                        <td>性別</td>
                            <td align="left"><?php echo $_SESSION['gender']; ?></td>
                        </tr>
                   
                        <tr>
                            <td>郵便番号</td>
                            <td align="left"><?php echo $_SESSION['postal_code']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(都道府県)</td>
                            <td align="left"><?php echo $_SESSION['prefecture']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(市町区村)</td>
                            <td><?php echo $_SESSION['address_1']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(番地)</td>
                            <td><?php echo $_SESSION['address_2']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>アカウント権限</td>
                            <td align="left"><?php echo $_SESSION['authority']; ?></td>
                        </tr>                   
    　　　　　　　　　　　　<th align="center">
                            <form action="update.php" method="post">
                            <button name="back" class="submit" value="前に戻る">前に戻る</button>
                            <input type=hidden value="<?php echo $_SESSION['family_name']; ?>" name="family_name">
                            <input type=hidden value="<?php echo $_SESSION['last_name']; ?>" name="last_name">
                            <input type=hidden value="<?php echo $_SESSION['family_name_kana']; ?>" name="family_name_kana">
                            <input type=hidden value="<?php echo $_SESSION['last_name_kana']; ?>" name="last_name_kana">
                            <input type=hidden value="<?php echo $_SESSION['mail']; ?>" name="mail">
                            <input type=hidden value="<?php echo $_SESSION['password']; ?>" name="password">
                            <input type=hidden value="<?php echo $_SESSION['gender']; ?>" name="gender">
                            <input type=hidden value="<?php echo $_SESSION['postal_code']; ?>" name="postal_code">
                            <input type=hidden value="<?php echo $_SESSION['prefecture']; ?>" name="prefecture">
                            <input type=hidden value="<?php echo $_SESSION['address_1']; ?>" name="address_1">
                            <input type=hidden value="<?php echo $_SESSION['address_2']; ?>" name="address_2">
                            <input type=hidden value="<?php echo $_SESSION['authority']; ?>" name="authority">
                            </form>
                        </th>
                        <th align="center">
                            <button onClick="location.href='http://localhost/accounts/update_complete.php'">更新する</button>
                        </th>
                        </table>
                     <?php else:?>
                     <h1><font color="red"><?php echo $e; ?></font></h1>
                     <?php endif; ?>
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>