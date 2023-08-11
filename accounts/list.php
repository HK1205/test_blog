<?php
session_start();
$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try{
if($_SESSION['yourauthority'] == 0){
    throw new Exception();
}
    
if(!isset($_POST['search'])){
    
$family_name="";
$last_name="";
$family_name_kana="";
$last_name_kana="";
$mail="";
$gender="";
$authority="";
$authorityType = array('一般','管理者');
    
}if(isset($_POST['search'])){
mb_internal_encoding("utf8");
    
$family_name= $_POST['family_name'];
$last_name= $_POST['last_name'];
$family_name_kana= $_POST['family_name_kana'];
$last_name_kana= $_POST['last_name_kana'];
$mail= $_POST['mail'];
$authorityType = array('一般','管理者');
    
    
if(isset($_POST['gender']) && ($_POST['gender']) == "男"){
    $gender = 0;
}else if(isset($_POST['gender']) && ($_POST['gender']) == "女"){
    $gender = 1;
}else{
    $gender = "";
}

if(!empty($_POST['authority']) && (($_POST['authority']) == "一般")){
    $authority = 0;
}else if(!empty($_POST['authority']) && (($_POST['authority']) == "管理者")){
    $authority = 1;
}else{
    $authority = "";
}
    
$pdo = new PDO("mysql:dbname=lesson01;host=localhost;","root","");
$rows = $pdo->prepare('select * from registration where family_name like :family_name and last_name like :last_name and family_name_kana like :family_name_kana and last_name_kana like :last_name_kana and mail like :mail and gender like :gender and authority like :authority  order by id desc');
$rows->bindValue(':family_name', '%'.$family_name.'%', PDO::PARAM_STR);
$rows->bindValue(':last_name', '%'.$last_name.'%', PDO::PARAM_STR);
$rows->bindValue(':family_name_kana', '%'.$family_name_kana.'%', PDO::PARAM_STR);
$rows->bindValue(':last_name_kana', '%'.$last_name_kana.'%', PDO::PARAM_STR);
$rows->bindValue(':mail', '%'.$mail.'%', PDO::PARAM_STR);
$rows->bindValue(':gender', '%'.$gender.'%', PDO::PARAM_STR);
$rows->bindValue(':authority', '%'.$authority.'%', PDO::PARAM_STR);
$rows->execute();
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
 <link rel="stylesheet" type="text/css" href="CSS/style.css">
 <title>D.I.BLOG</title>
</head>
<body>
<script>
let num = 0;   
function deletecheck(obj, currentNum){
    if(num === currentNum){
        obj.checked=false;
        num = 0;
    }else{
        num = currentNum;
    }
} 
</script>
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
<div class="search">
    <form action="" method="post">
    <table class="searcharea" border="1" cellspacing="0" cellpadding="5">
        <tr>
            <td width="12%">名前(姓)</td><td><input type="text" name="family_name" value="<?=$family_name?>" size="100%"></td><td width="12%">名前(名)</td><td><input type="text" name="last_name" value="<?=$last_name?>" size="100%"></td>
        </tr>
        <tr>
            <td>カナ(姓)</td><td><input type="text" name="family_name_kana" value="<?=$family_name_kana?>" size="100%"></td><td>カナ(名)</td><td><input type="text" name="last_name_kana" value="<?=$last_name_kana?>" size="100%"></td>
        </tr>        
        <tr>
            <td>メールアドレス</td><td><input type="text" name="mail" value="<?=$mail?>" size="100%"></td>
            <td>性別</td>
            <td>
            <?php
            if(isset($_POST['gender']) && (($_POST['gender']) == "男")){
            echo "<label for ='男'>男<input type='radio' id='男' name='gender' value='男' onClick='deletecheck(this, 1)' checked></label>";
            echo "<label for ='女'>女<input type='radio' id='女' name='gender' value='女' onClick='deletecheck(this, 2)'></label>"; 
 
            }else if(isset($_POST['gender']) && (($_POST['gender']) == "女")){
            echo "<label for ='男'>男<input type='radio' id='男' name='gender' value='男' onClick='deletecheck(this, 1)'></label>";
            echo "<label for ='女'>女<input type='radio' id='女' name='gender' value='女' onClick='deletecheck(this, 2)' checked></label>"; 
                                
            }else if(empty($_POST['gender'])){
            echo "<label for ='男'>男<input type='radio' id='男' name='gender' value='男' onClick='deletecheck(this, 1)'></label>";
            echo "<label for ='女'>女<input type='radio' id='女' name='gender' value='女' onClick='deletecheck(this, 2)'></label>";    
            }                 
            ?>
            </td>
        </tr>
        <tr>
            <td>アカウント権限</td>
            <td>
                <div class="authority">
                <select name="authority">
                <option value=""></option>
                <?php
                foreach($authorityType as $value){
                if(!empty($_POST['authority'])){
                if($value === $_POST['authority']){
                echo '<option value="'.$value.'" selected>'.$value.'</option>';
                }else{
                echo '<option value="'.$value.'">'.$value.'</option>';
                }
                }else{
                echo '<option value="'.$value.'">'.$value.'</option>';
                }
                }
                ?>
                </select>
                </div>
            </td>
            <td></td><td></td>
        </tr>
    </table>
        <input type="submit" name="search" value="検索" size="20">
    </form>
</div>
    
<?php if(isset($_POST['search'])): ?>
<table class="result" border="1" cellspacing="0" cellpadding="5" width="100%">
<tr>
<th>ID</th><th>名前(姓)</th><th>名前(名)</th><th>カナ(姓)</th><th>カナ(名)</th><th>メールアドレス</th><th>性別</th><th>アカウント権限</th><th>削除フラグ</th><th>登録日時</th><th>更新日時</th><th colspan="2">操作</th>
</tr>
<?php
while($row = $rows->fetch()){
    echo "<tr>";
    echo "<td align='center'>";
    echo $row['id'];
    echo "</td>";
    echo "<td align='center'>";
    echo $row['family_name'];
    echo "</td>";
    echo "<td align='center'>";
    echo $row['last_name'];
    echo "</td>";
    echo "<td align='center'>";
    echo $row['family_name_kana'];
    echo "</td>";
    echo "<td align='center'>";
    echo $row['last_name_kana'];
    echo "</td>";
    echo "<td align='center'>";
    echo $row['mail'];
    echo "</td>";
    echo "<td align='center'>";
    if($row['gender'] == 0){
    echo "男";
    }else{
    echo "女";
    }
    echo "</td>";
    echo "<td align='center'>";
    if($row['authority'] == 0){
    echo "一般";
    }else{
    echo "管理者";
    }
    echo "</td>";
    echo "<td align='center'>";
    if($row['delete_flag'] == 0){
    echo "有効";
    }else{
    echo "無効";
    }
    echo "</td>";
    echo "<td align='center'>";
    $date1 = new Datetime($row['registered_time']);
    echo $date1->format('Y/m/d');
    echo "</td>";
    echo "<td align='center'>";
    $date2 = new Datetime($row['update_time']);
    echo $date2->format('Y/m/d');
    echo "</td>";
    echo "<td align='center'>";
    echo "<form action='update.php' method='post'>";
    echo '<input type="hidden" value="'.$row['id'].'" name="ID">';
    echo '<input type="submit" name="delete" value="更新">';
    echo "</form>";
    echo "</td>";
    echo "<td align='center'>";
    echo "<form action='delete.php' method='post'>";
    echo '<input type="hidden" value="'.$row['id'].'" name="ID">';
    echo '<input type="submit" name="delete" value="削除">';
    echo "</form>";
    echo "</td>";
    echo "</tr>";
} 
?>
</table>
<?php endif; ?>
<?php else:?>
<h1><font color="red"><?php echo $e; ?></font></h1>
<?php endif; ?>
    


</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>