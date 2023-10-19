<?php
// Connexion à la base de données avec PDO
$dsn = 'mysql:host=localhost;dbname=finalbattle';
$username = 'isma69';
$password = '9Janvier1996';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}
