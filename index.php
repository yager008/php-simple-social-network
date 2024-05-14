<?php
include_once("Router.php");

Router::handle('GET', '/table', 'mysqltable.php');
Router::handle('GET', '/login', 'loginpage.php');
Router::handle('GET', '/userpage', 'userpage.php');
Router::handle('POST', '/table', 'mysqltable.php');
Router::handle('POST', '/login', 'loginpage.php');
Router::handle('POST', '/userpage', 'userpage.php');
