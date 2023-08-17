<?php
function conectar()
{

    $host = 'localhost';
    $db = 'tcc';
    $user = 'root';
    $password = '';
    

    $dsn = ("mysql:host=$host;dbname=$db");
    $pdo = new PDO($dsn, $user, $password );
    return $pdo;
}