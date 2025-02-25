<?php
include("../config/config.php");// Inclut la configuration bdd

$message = '';// Affiche les erreurs de connexion

// Verifie que la requête est POST 
// Execute la condition que si le formulaire a bien été soumis 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Récupération des données saisies
    $username = trim($_POST['username']);//Supprime les espaces inutiles
    $email = trim($_POST['email']);
    $password = ($_POST['password']);
    
    $message = '';

    // Validation des entrées utilisateur.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email invalide';
    }elseif (strlen($username) < 3) {
        $message = 'Le nom d\'utilisateur doit contenir au moins 3 caractères.';
    } elseif (strlen($password) < 6) {
        $message = 'Le mot de passe doit contenir au moins 6 caractères.';
    }

    // Si les données sont valides
    if (empty($message)) {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Connexion à la base de données
            $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
            $stmt = $pdo->prepare($sql);

            // Liaison des paramètres avec les valeurs
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);

            // Exécution de la requête
            $res = $stmt->execute();

            if ($res) {
                // Si l'insertion est réussie, redirection vers la page de connexion
                $message = 'Inscription réussie!';
                header('Location: login.php');
                exit(); // Pour éviter que le script continue après la redirection
            } else {
                // En cas d'erreur lors de l'insertion
                $message = 'Erreur lors de l\'inscription, veuillez réessayer.';
            }
        } catch (PDOException $e) {
            // Gestion des erreurs de la base de données
            $message = 'Erreur de base de données : ' . $e->getMessage();
        }
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
    <title>QuizNight</title>
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
        <section class="register-container">
            <h1 class="register-title">S'inscrire</h1>
            <?php if (!empty($message)) : ?>
                <p><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form method=POST action="" class="register-form">
                <img src="../assets/logo.png" alt="logo" class="logo-form">
                <label for="username">Entrez votre nom d'utilisateur</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Entrez votre nom d'utilisateur"
                    required
                /></br>
                <label for="email">Entrez votre adresse mail</label>
                <input
                    type=email
                    id="email" 
                    name="email" 
                    placeholder="Entrez votre adresse mail"
                    required
                /></br>
                <label for="password">Entrez votre mot de passe</label>
                <input
                    type=password
                    id="password" 
                    name="password" 
                    placeholder="Entrer votre mot de passe"
                /></br>
                <input 
                    type="submit" 
                    name="submit" 
                    value="S'inscrire" 
                    class="register-button" 
                />
                <p class="box-register">
                    Déjà inscrit ? 
                    <a href="login.php">Connectez-vous ici</a>
                </p>
                <p class="terms-of-use">
                    En créant un compte, vous acceptez nos Conditions d'utilisation. <br>
                    Découvrez comment nous traitons vos données dans notre Politique de confidentialité.
                </p>
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