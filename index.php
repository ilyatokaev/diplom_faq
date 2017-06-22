<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'start_init.php';

Cfg::setCurrentRoles('/Guest');

header("Location: router.php?params=Question_userList");