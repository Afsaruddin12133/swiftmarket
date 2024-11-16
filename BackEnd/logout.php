<?php
session_start();


session_destroy();

header("Location: ../FrontEnd/html/login.html");
exit;
?>
