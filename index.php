<?php
    include("tpl.php");
    include("init.php");


    setcookie('sessionID', $session_num, time()+60*60*24*30);
?>