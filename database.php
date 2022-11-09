<?php

$mysqli = new mysqli('localhost', 'jkr', 'cqygfxgfst', 'news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>