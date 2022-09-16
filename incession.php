<?php
require('config.php');

// Check for a cookie, if none go to login page
if (!isset($_COOKIE['session_id']))
{
    header('Location: login.php?refer='. urlencode(getenv('REQUEST_URI')));
}

// Try to find a match in the database
$guid = $_COOKIE['session_id'];
$con = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $con);

$query = "SELECT userid FROM susers WHERE guid = '$guid'";
$result = mysql_query($query, $con);

if (!mysql_num_rows($result))
{
    // No match for guid
header('Location: login.php?refer='. urlencode(getenv('REQUEST_URI')));
}
?>

<!--一開始會檢查有沒有 cookie，記得 actionlogin.php 裡面有設定 cookie 的 session_id。
如果沒有 cookie 表示會員還沒登入，然後轉址到 login.php，加上 refer 的網址。
接下來將 $guid 設為 cookie 裡面的 session_id，然後進行查詢的動作。
如果 mysql_num_rows($result) 裡面沒有東西，表示 cookie 裡的 session_id 跟資料庫裡的 guid 不一樣。
如果不一樣，進入登入頁面。-->
