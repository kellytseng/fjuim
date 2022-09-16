<?php
include('incsession.php');

echo '這是會員區';
?>

<!--當會員進入 test.php 的時候會先用 incsession.php 來檢查 cookie。
如果驗證不通過會進入登入頁面。如果成功會顯示 "這是會員區"。-->
