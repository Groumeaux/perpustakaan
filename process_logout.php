<?php
// Mulai session
session_start();
// Hancurkan session
session_destroy();
// Redirect ke halaman utama setelah logout
header("Location: index.php");
exit();
?>