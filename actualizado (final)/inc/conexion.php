<?php
$host = '192.168.136.129'; 
$dbname = 'biblioteca';  
$username = 'postgres';   
$password = '54321';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();

}
