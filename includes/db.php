<?php
$host = 'localhost';
$port = '3306';
$db = 'readnshare';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$username = "root";
$password = '';
$pdo = new PDO($dsn, $username, $password);

