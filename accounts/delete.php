<?php
mb_internal_encoding("utf8");
session_start();

$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";
$accessdeny="localhost/userlogin/login.php";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try{
    
if($_SESSION['yourauthority'] == 0){
    throw new Exception();
}

if(!empty($_POST['ID'])){
    $_SESSION['ID'] = $_POST['ID'];
    $id = $_SESSION['ID'];
}else{
    $id = $_SESSION['ID'];
}

$pdo = new pdo("mysql:dbname=lesson01;host=localhost", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("select family_name, last_name, family_name_kana, last_name_kana, mail, convert(AES_DECRYPT(UNHEX(password),'cryptkey') Using utf8) as ex_password, gender, postal_code, prefecture, address_1, address_2, authority from registration where id = :id ");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

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
                            <th colspan="2" align="center"><a>アカウント削除画面</a></th>
                        </tr>
                        <tr>
                            <td>名前(姓)</td>
                            <td><?php echo $data['family_name']; ?></td>
                        </tr>
                       
                        <tr>
                            <td>名前(名)</td>
                            <td><?php echo $data['last_name']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>カナ(姓)</td>
                            <td><?php echo $data['family_name_kana']; ?></td>
                        </tr>
                   
                        <tr>
                            <td>カナ(名)</td>
                            <td><?php echo $data['last_name_kana']; ?></td>
                        </tr>
                   

                        <tr>
                            <td>メールアドレス</td>
                            <td><?php echo $data['mail']; ?></td>
                        </tr>
                   
                        <tr>
                            <td>パスワード</td>
                            <td>
                                <?php 
                                
                                
                                echo str_repeat('●', strlen($data['ex_password'])); 
                                ?>
                            </td>
                        </tr>
                   
                        <tr>
                        <td>性別</td>
                            <td align="left">
                            <?php if($data['gender'] == 0){
                              echo "男";
                            }else{
                              echo "女";
                            } ?>
                            </td>
                        </tr>
                   
                        <tr>
                            <td>郵便番号</td>
                            <td align="left"><?php echo $data['postal_code']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(都道府県)</td>
                            <td align="left"><?php echo $data['prefecture']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(市町区村)</td>
                            <td><?php echo $data['address_1']; ?></td>
                        </tr>
                           
                        <tr>
                            <td>住所(番地)</td>
                            <td><?php echo $data['address_2']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>アカウント権限</td>
                            <td align="left">
                            <?php if($data['authority'] == 0){
                              echo "一般";
                            }else{
                              echo "管理者";
                            } ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <button onClick="location.href='http://localhost/accounts/delete_confirm.php'">確認する</button>
                            </th>
                        </tr>
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