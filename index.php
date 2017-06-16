<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'start_init.php';

Cfg::setCurrentRoles('/Guest');

$clientView = new ClientView("qq_list");

$clientView->show();