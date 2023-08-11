<?php
session_start();
$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) === false) || empty($_COOKIE['yourcookie'])){
    header('Location: http://localhost/userlogin/login.php');
}

if(!empty($_POST['submit'])){
    $handlename = $_POST['handlename'];
    $title = $_POST['title'];
    $comments = $_POST['comments'];

if($handlename !== "" && $title !== "" && $comments !== ""){
    $_SESSION['handlename'] = $_POST['handlename'];
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['comments']= $_POST['comments'];
    header("Location: http://localhost/diworks_keijiban/insert.php");
}

}else{
    $handlename = "";
    $title = "";
    $comments = "";
}
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="style.css">
 <title>D.I.BLOG</title>
</head>
<body>
    
<?php 
mb_internal_encoding("utf8");
$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$stmt = $pdo->query("select * from diworks_keijiban");
?>
       
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
     <div class="main-container">
           <div class="left">
               <div class="headline">プログラミングに役立つ掲示板</div>
               <form method="post" action="">
               <p>入力フォーム</p>
                   <div>
                   <label>ハンドルネーム<br></label>
                   <input type="text" class="text" name="handlename" value="<?=$handlename?>" size="40">
                   <?php if(!empty($_POST['submit']) && $handlename === ""): ?>
                   <font color="red">ハンドルネームを入力してください</font>
                   <?php endif; ?>
                   </div>
                   <br>
                   
                   <div>
                   <label>タイトル<br></label>
                   <input type="text" class="text" name="title" value="<?=$title?>" size="40">
                   <?php if(!empty($_POST['submit']) && $title === ""): ?>
                   <font color="red">タイトルを入力してください</font>
                   <?php endif; ?>
                   </div>
                   <br>
                   
                   <div>
                   <label>コメント<br></label>
                   <textarea rows="7" style="width:60%" class="text" name="comments"><?php echo $comments ?></textarea>
                   <?php if(!empty($_POST['submit']) && $comments === ""): ?>
                   <font color="red">コメントを入力してください</font>
                   <?php endif; ?>
                   </div>
                   <input type="submit" name="submit" class="submit" value="投稿する"> 
               </form>
               
<?php
        while($row = $stmt->fetch()){        
            echo "<div class='commentsection'>";
            echo  "<h3>".$row['title']."</h3>";
            echo "<div class='comments'>";
            echo $row['comments'];
            echo  "</div>";
            echo "<div class='handlename'>posted by ".$row['handlename']."</div>";    
            echo "</div>";
        }
?>       
            </div>
            <div class="right">
                <div id="hottopic">
                    <p class="menu">人気の記事</p>
                     <ul>
                         <li>PHPオススメ本</li>
                         <li>PHP MyAdminの使い方</li>
                         <li>いま人気のエディタTops</li>
                         <li>HTMLの基本</li>
                    </ul>
                    <p class="menu">オススメリンク</p>
                     <ul>
                         <li>ディーアイワークス株式会社</li>
                         <li>XAMPPのダウンロード</li>
                         <li>Eclipseのダウンロード</li>
                         <li>Braketsのダウンロード</li>
                     </ul>
                    <p class="menu">カテゴリ</p>
                     <ul>
                         <li>HTML</li>
                         <li>PHP</li>
                         <li>MySQL</li>
                         <li>JavaScript</li>
                    </ul>           
                </div>
            </div>
        </div>
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>