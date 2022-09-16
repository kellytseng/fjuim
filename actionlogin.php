<?php
require('config.php');

$email = $_POST['email'];
$password = $_POST['password'];
$refer = $_POST['refer'];

if ($email == '' || $password == '')
{
    // No login information
    header('Location: login.php?refer='. urlencode($_POST['refer']));
}
else
{
    // Authenticate user
    $con = mysql_connect($db_host, $db_user, $db_pass);
    mysql_select_db($db_name, $con);
    
    $query = "SELECT userid, MD5(UNIX_TIMESTAMP() + userid + RAND(UNIX_TIMESTAMP()))
        guid FROM susers WHERE email = '$email' AND password = password('$password')";
        
    $result = mysql_query($query, $con)
    	or die ('Error in query');
    
    if (mysql_num_rows($result))
    {
        $row = mysql_fetch_row($result);
        // Update the user record
        $query = "UPDATE susers SET guid = '$row[1]' WHERE userid = $row[0]";
            
        mysql_query($query, $con)
        	or die('Error in query');
        
        // Set the cookie and redirect
        // setcookie( string name [, string value [, int expire [, string path
        // [, string domain [, bool secure]]]]])
        // Setting cookie expire date, 6 hours from now
        $cookieexpiry = (time() + 21600);
        setcookie("session_id", $row[1], $cookieexpiry);

        if (empty($refer) || !$refer)
        {
            $refer = 'index.php';
        }

        header('Location: '. $refer);
    }
    else
    {
        // Not authenticated
        header('Location: login.php?refer='. urlencode($refer));
    }
}
?>

<!--首先檢查會員有沒有輸入帳號和密碼，如果沒有回到登入頁面，用最後面的 header 來控制。
接下來是到資料庫尋找會員的資料。
第一個資料庫的查詢會用 MD5() 函式來建立會員的 session id，然後檢查帳號跟密碼是否跟資料庫裡的相同。
如果相同，更新會員的 session id，這樣可以增加安全性。
所以會員的 session id 每登入一次就會不同。
接下來是建立一個 cookie，只要會員在六個小時內回到網頁就不需要重新登入。
後面的 if (empty($refer) || !$refer) 是為了轉址的功能。
如果有 refer 的值，會員在登入後會回到之前的網頁，沒有就回到 index.php。-->
