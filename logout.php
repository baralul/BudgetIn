<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
header("Location: pages/forms/account_login.php");
exit;
?>
