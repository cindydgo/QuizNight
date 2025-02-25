<?php
//Démarre la session et la sécurise 
session_start();

include("../config/config.php");//Inclut la configuration bdd

$message = '';//Affiche les erreurs de connexion

//Vérifie si les informations du formulaire sont envoyées
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère et sécurise les données du formulaire
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    
    // Requête pour récupérer l'utilisateur depuis la base de données
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    
    // Vérification si l'utilisateur existe et si le mdp est correct
    if ($user && password_verify($password, $user['password'])) {
        // Regénère l'ID de la session pour prévenir les attaques de fixation de session
        session_regenerate_id();
        // Stocke l'identifiant de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        // Redirige vers le tableau de bord
        header('Location: admin.php');
        exit(); //le script s'arrête après la redirection
    } else {
        $message = 'Mauvais identifiants';
    } 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/style.css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <nav class="nav-bar">
            <i class="fa-solid fa-bars"></i>
            <a href="../index.php" class="home-logo">
                <img src="../assets/logo.png" alt="logo" class="logo">
            </a>
        </nav>
    </header>
    <main>
        <section class="login-container">
            <h2 class="login-title">Connexion</h2>
            <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <form action="login.php" method="post" class="login-form">
                <img src="../assets/logo.png" alt="logo" class="logo-form">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password">
                <input type="submit" name="submit" value="Se connecter">
            </form>
        </section>
    </main>
    <footer class="footer">
        <ul>
            <li>©QuizNight</li>
            <li>Mentions légales</li>
            <li>Politique de confidentialité</li>
            <li>Contact</li>
        </ul>
    </footer>
</body>
</html>