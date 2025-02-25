<?php 

$host = 'localhost';
$db = 'quiznight';
$username = 'root';
$password = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host; dbname=$db; charset = $charset"; 

//On établit la connexion avec la bdd
try
{
    $pdo = new PDO($dsn, $username, $password);

    // Définir le mode d'erreur pour les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (\PDOException $e) {
    // Gestion des erreurs de connexion
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
