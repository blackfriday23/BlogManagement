<?php
session_start();

include_once "../appdata/sessionHandle.php";
//include('../appdata/sessionHandle.php');

$session = new sessionHandle();

$session->destroy_session();

header('Location: ../index.php');
?>