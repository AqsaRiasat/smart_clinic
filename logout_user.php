<?php
session_start();

// Clear Session Data
session_unset();
session_destroy();

header("Location: user_login.php");
exit();
?>