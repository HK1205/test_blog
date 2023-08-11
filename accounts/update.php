<?php
session_start();
$referer = isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : "";
$host="localhost";

if((!empty($referer) && strpos($referer, $host) !== false) || !empty($_COOKIE['yourcookie'])){

try{
    
if($_SESSION['yourauthority'] == 0){
    throw new Exception();
}

 $family_name = "";
 $last_name = "";
 $family_name_kana = "";
 $last_name_kana = "";
 $mail = "";
 $password = "";
 $gender = "";
 $postal_code = "";
 $prefecture = "";
 $address_1 = "";
 $address_2 = "";
 $authority = "";
 $errmsg[] = "";
 $authorityType = array('一般','管理者');
 $PrefList =array(
     '北海道',
     '青森県',
     '秋田県',
     '岩手県',
     '山形県',
     '宮城県',
     '福島県',
     '新潟県',
     '茨城県',
     '群馬県',
     '栃木県',
     '千葉県',
     '埼玉県',
     '東京都',
     '神奈川県',
     '山梨県',
     '長野県',
     '静岡県',
     '富山県',
     '石川県',
     '福島県',
     '愛知県',
     '岐阜県',
     '滋賀県',
     '三重県', 
     '大阪府',
     '奈良県',
     '和歌山県',
     '京都府',
     '兵庫県',
     '香川県',
     '徳島県',
     '愛媛県',
     '高知県',
     '岡山県',
     '鳥取県',
     '広島県',
     '島根県',
     '山口県',
     '福岡県',
     '佐賀県',
     '大分県',
     '長崎県',
     '熊本県',
     '宮崎県',
     '鹿児島県',
     '沖縄県'
     );


if(!isset($_POST['back'])){
    
mb_internal_encoding("utf8");

if(!empty($_POST['ID'])){
    $_SESSION['ID'] = $_POST['ID'];
    $id = $_SESSION['ID'];
}else{
    $id = $_SESSION['ID'];
}

$pdo = new pdo("mysql:dbname=lesson01;host=localhost", "root", "");

$stmt = $pdo->prepare("select family_name, last_name, family_name_kana, last_name_kana, mail, convert(AES_DECRYPT(UNHEX(password),'cryptkey') Using utf8) as ex_password, gender, postal_code, prefecture, address_1, address_2, authority from registration where id = :id ");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);


 $family_name = $data['family_name'];
 $last_name = $data['last_name'];
 $family_name_kana = $data['family_name_kana'];
 $last_name_kana = $data['last_name_kana'];
 $mail = $data['mail'];
 $password = $data['ex_password'];
 $gender = $data['gender'];
 $postal_code = $data['postal_code'];
 $prefecture = $data['prefecture'];
 $address_1 = $data['address_1'];
 $address_2 = $data['address_2'];
 $authority = $data['authority'];
    
}else if(isset($_POST['back'])){

 $family_name = $_POST['family_name'];
 $last_name = $_POST['last_name'];
 $family_name_kana = $_POST['family_name_kana'];
 $last_name_kana = $_POST['last_name_kana'];
 $mail = $_POST['mail'];
 $password = $_POST['password'];
 $gender = $_POST['gender'];
 $postal_code = $_POST['postal_code'];
 $prefecture = $_POST['prefecture'];
 $address_1 = $_POST['address_1'];
 $address_2 = $_POST['address_2'];
 $authority = $_POST['authority'];
     
}



if(isset($_POST['submit'])){
    
 $family_name = $_POST['family_name'];
 $last_name = $_POST['last_name'];
 $family_name_kana = $_POST['family_name_kana'];
 $last_name_kana = $_POST['last_name_kana'];
 $mail = $_POST['mail'];
 $password = $_POST['password'];
 $gender = $_POST['gender'];
 $postal_code = $_POST['postal_code'];
 $prefecture = $_POST['prefecture'];
 $address_1 = $_POST['address_1'];
 $address_2 = $_POST['address_2'];
 $authority = $_POST['authority'];
    
 unset($errmsg);
    
    
if(isset($_POST['family_name']) && (($_POST['family_name']) == "")){
    $errmsg[0] = "名前(姓)が未入力です。";
}

if(isset($_POST['last_name']) && (($_POST['last_name']) == "")){
    $errmsg[1] = "名前(名)が未入力です。";
}

if(isset($_POST['family_name_kana']) && (($_POST['family_name_kana']) == "")){
    $errmsg[2] = "カナ(姓)が未入力です。";
}

if(isset($_POST['last_name_kana']) && (($_POST['last_name_kana']) == "")){
    $errmsg[3] = "カナ(名)が未入力です。";
}

if(isset($_POST['mail']) && (($_POST['mail']) == "")){
    $errmsg[4] = "メールアドレスが未入力です。";
}

if(isset($_POST['password']) && (($_POST['password']) == "")){
    $errmsg[5] = "パスワードが未入力です。";
}

if(isset($_POST['postal_code']) && (($_POST['postal_code']) == "")){
    $errmsg[6] = "郵便番号が未入力です。";
}

if(isset($_POST['prefecture']) && (($_POST['prefecture']) == "")){
    $errmsg[7] = "都道府県を選んでください。";
}

if(isset($_POST['address_1']) && (($_POST['address_1']) == "")){
    $errmsg[8] = "住所(市町区村)が未入力です。";
}
    
if(isset($_POST['address_2']) && (($_POST['address_2']) == "")){
    $errmsg[9] = "住所(番地)が未入力です。";
}
    

if(empty($errmsg)){   
 session_start();
    
 $_SESSION['family_name'] = $_POST['family_name'];
 $_SESSION['last_name']  = $_POST['last_name'];
 $_SESSION['family_name_kana'] = $_POST['family_name_kana'];
 $_SESSION['last_name_kana'] = $_POST['last_name_kana'];
 $_SESSION['mail'] = $_POST['mail'];
 $_SESSION['password'] = $_POST['password'];
 $_SESSION['gender'] = $_POST['gender'];
 $_SESSION['postal_code'] = $_POST['postal_code'];
 $_SESSION['prefecture'] = $_POST['prefecture'];
 $_SESSION['address_1'] = $_POST['address_1'];
 $_SESSION['address_2'] = $_POST['address_2'];
 $_SESSION['authority'] = $_POST['authority'];

 header('Location: http://localhost/accounts/update_confirm.php');
 exit();
}
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
 <link rel="stylesheet" type="text/css" href="CSS/style3.css">
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
               <form method="post" action="">     
                       <table>
                        <tr>
                            <th colspan="2" align="center"><a>アカウント更新画面</a></th>
                        </tr>
                        <tr>
                            <td>名前(姓)</td>
                            <td><input type="text" class="text" name="family_name" pattern="[\u4E00-\u9FFF\u3040-\u309F]{1,10}" size="40" value="<?=$family_name?>" placeholder="田中">
                            <?php
                              if(isset($_POST['family_name']) && (($_POST['family_name']) == "")){
                                  echo "<font color='red'><br>$errmsg[0]</font>";
                              }
                            ?>
                            </td>
                        </tr>
                       
                        <tr>
                            <td>名前(名)</td>
                            <td><input type="text" class="text" name="last_name" pattern="[\u4E00-\u9FFF\u3040-\u309F]{1,10}" size="40" value="<?=$last_name?>" placeholder="太郎">
                            <?php
                              if(isset($_POST['last_name']) && (($_POST['last_name']) == "")){
                                  echo "<font color='red'><br>$errmsg[1]</font>";
                              }
                            ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>カナ(姓)</td>
                            <td><input type="text" class="text" name="family_name_kana" pattern="[\u30A1-\u30F6]{1,10}" size="40" value="<?=$family_name_kana?>" placeholder="タナカ">
                            <?php
                              if(isset($_POST['family_name_kana']) && (($_POST['family_name_kana']) == "")){
                                  echo "<font color='red'><br>$errmsg[2]</font>";
                              }
                            ?>       
                            </td>
                        </tr>
                   
                        <tr>
                            <td>カナ(名)</td>
                            <td><input type="text" class="text" name="last_name_kana" pattern="^[\u30A1-\u30F6]{1,10}" size="40" value="<?=$last_name_kana?>" placeholder="タロウ">
                            <?php
                              if(isset($_POST['last_name_kana']) && (($_POST['last_name_kana']) == "")){
                                  echo "<font color='red'><br>$errmsg[3]</font>";
                              }
                            ?>    
                            </td>
                        </tr>
                   
                        <tr>
                            <td>メールアドレス</td>
                            <td><input type="text" class="text" name="mail" pattern="[a-zA-Z0-9]+@([a-zA-Z0-9])([a-zA-Z0-9\-]*)([a-zA-Z0-9]+)(\.[a-z]{2,3})*$" size="40" value="<?=$mail?>" placeholder="例)abc@di-works.co.jp">
                            <?php
                              if(isset($_POST['mail']) && (($_POST['mail']) == "")){
                                  echo "<font color='red'><br>$errmsg[4]</font>";
                              }
                            ?>
                            </td>
                        </tr>
                           
                        <tr>
                            <td>パスワード</td>
                            <td><input type="text" class="text" name="password" pattern="([0-9a-zA-Z]{5,10})" size="40" value="<?=$password?>" placeholder="半角英数字を5～10文字で入力してください">
                            <?php
                              if(isset($_POST['password']) && (($_POST['password']) == "")){
                                  echo "<font color='red'><br>$errmsg[5]</font>";
                              }
                            ?>    
                            </td>
                        </tr>
                   
                        <tr>
                        <td>性別</td>
                            <td align="left">
                            <?php
                                if((isset($_POST['gender']) && (($_POST['gender']) == "男")) || (isset($data['gender']) && (($data['gender']) == "0"))){
                                echo "<label for ='男'>男<input type='radio' id='男' name='gender' value='男' checked></label>";
                                echo "<label for ='女'>女<input type='radio' id='女' name='gender' value='女'></label>"; 
 
                                }else if((isset($_POST['gender']) && (($_POST['gender']) == "女")) || (isset($data['gender']) && (($data['gender']) == "1"))){
                                echo "<label for ='男'>男<input type='radio' id='男' name='gender' value='男'></label>";
                                echo "<label for ='女'>女<input type='radio' id='女' name='gender' value='女' checked></label>"; 
                                
                                }
                                
                             ?>
                                </td>
                        </tr>
                   
                        <tr>
                            <td>郵便番号</td>
                            <td align="left"><input type="text" class="text" pattern="[1-9]([0-9]{6})" name="postal_code" size="10" value="<?=$postal_code?>" placeholder="例)1234567">
                            <?php
                              if(isset($_POST['postal_code']) && (($_POST['postal_code']) == "")){
                                  echo "<font color='red'><br>$errmsg[6]</font>";
                              }
                            ?>    
                            </td>
                        </tr>
                           
                        <tr>
                            <td>住所(都道府県)</td>
                            <td align="left"><select name="prefecture">
                                <option value=""></option>
                                <?php
                                foreach($PrefList as $value){
                                    if(!empty($data['prefecture']) || !empty($_POST['prefecture'])){
                                        if($value == $prefecture){
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
                            <?php                                  
                                if(isset($_POST['prefecture']) && (($_POST['prefecture']) == "")){
                                  echo "<font color='red'><br>$errmsg[7]</font>";
                                }
                            ?>
                            </td>
                        </tr>
                           
                        <tr>
                            <td>住所(市町区村)</td>
                            <td><input type="text" class="text" name="address_1" pattern="[\u4E00-\u9FFF\u3040-\u309F\u30A1-\u30F6\s]{1,10}" size="20" value="<?=$address_1?>">
                            <?php
                              if(isset($_POST['address_1']) && (($_POST['address_1']) == "")){
                                  echo "<font color='red'><br>$errmsg[8]</font>";
                              }
                            ?>     
                            </td>
                        </tr>
                           
                        <tr>
                            <td>住所(番地)</td>
                            <td><input type="text" class="text" name="address_2" pattern="[1-9]([0-9]*)(-[1-9]([0-9]*))*" size="20" value="<?=$address_2?>" placeholder="例)1-23-45">
                            <?php
                              if(isset($_POST['address_2']) && (($_POST['address_2']) == "")){
                                  echo "<font color='red'><br>$errmsg[9]</font>";
                              }
                            ?>     
                            </td>
                        </tr>
                        
                        <tr>
                            <td>アカウント権限</td>
                            <td align="left"><select name="authority">
                            <?php
                                foreach($authorityType as $key => $value){
                                    if(!empty($_POST['authority']) || !empty($data['authority'])){
                                        if($value == $authority || $key == $authority){
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
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" align="center"><input type="submit" name="submit" class="submit" value="確認する"></th>
                        </tr>
                    </table>
               </form>
         <?php else:?>
         <h1><font color="red"><?php echo $e; ?></font></h1>
         <?php endif; ?>
</main>
    <footer>
        Copyright D.I.works| D.I.Blog is the one which provides A to Z about programming
    </footer>  
</body>
</html>