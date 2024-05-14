<?php

if (!isset($_SESSION['bShowChat']))
{
$_SESSION['bShowChat'] = false;
}

if (!isset($_SESSION['IDofChatter']))
{
$_SESSION['IDofChatter'] = 0;
}

if (!isset($_SESSION['tableName']))
{
$_SESSION['tableName'] = null;
}

if (!isset($_SESSION['chatterRowRef']))
{
$_SESSION['chatterRowRef'] = null;
}

if (!isset($_SESSION['bShowTable']))
{
$_SESSION['bShowTable'] = true;
}

if (!isset($_SESSION['bEditProfile']))
{
$_SESSION['bEditProfile'] = false;
}
