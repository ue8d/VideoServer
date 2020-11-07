<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['userName']);

$_SESSION['logoutMsg'] = "sample";
header('Location: /');