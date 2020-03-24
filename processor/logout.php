<?php
require_once "./../config.php";
session_start();
unset(
    $_SESSION[APPNAME]['name'],
    $_SESSION[APPNAME]['userid'],
    $_SESSION[APPNAME]['level']
);
header('Location: ./../');
