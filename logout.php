<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['userName']);
unset($_SESSION['role']);

$_SESSION['logoutMsg'] = "sample";
header('Location: /');