<html>
<head><title>Login</title>
</head>
<body>

<form action="actionlogin.php" method="POST">
帳號:<br />
<input type="text" name="email">
<br />
密碼:<br />
<input type="password" name="password">
<br />
<input type="submit" name="submit" value="Login">
<input type="hidden" name="refer" value="<?php echo (isset($_GET['refer'])) ? $_GET['refer'] : 'index.php'; ?>">
</form>
</body>
</html>

<!--上面的隱藏 input 是為了在登入後能夠回到之前的網頁。
如果 refer 有資料，表示會員先到了需要登入的頁面。
如果 refer 沒有資料，在登入後轉址到 index.php。-->
