<?php
include('../config/config.php');
require('../classes/Quiz.php');

// Récupère toutes les questions avec leurs réponses et catégories
$stmt = $pdo->query("SELECT questions.id AS question_id, questions.question, GROUP_CONCAT(reponses.reponse ORDER BY reponses.id ASC) AS reponses, categories.category_name FROM questions
    INNER JOIN reponses ON questions.id = reponses.question_id
    INNER JOIN categories ON questions.category_id = categories.id
    GROUP BY questions.id"); // Ajout de GROUP BY pour éviter les doublons dans les questions

if ($stmt === false) {
    $error = $pdo->errorInfo();
    var_dump($error);  // Affiche les erreurs SQL si requête échoue
} else {
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($questions); // Affiche les résultats si les données sont récupérées
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
    <title>Jeu de Questions</title>
</head>
<body>
    <header>
        <nav class="nav-bar">
            <i class="fa-solid fa-bars"></i>
            <a href="../index.php" class="home-logo">
                <img src="../assets/logo.png" alt="logo" class="logo">
            </a>
            <ul>
                <li>
                    <a href="./login.php">Mon compte</a>
                </li>
                <li>
                    <a href="./register.php">S'inscrire</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="questions_section">
            <h1>Jeu de Questions</h1>
            <form method="post" action="./resultat.php" id="question_form">
                <?php foreach ($questions as $i => $question): ?>
                    <div class="fieldset">
                        <legend><u>Question <?= $i + 1; ?> (Catégorie: <?= $question['category_name']; ?>)</u></legend> 
                        <p><strong><?= $question['question']; ?></strong></p>

                        <?php
                        // Récupérer toutes les réponses sous forme de tableau
                        $reponses = explode(',', $question['reponses']);
                        ?>

                        <!-- Affiche les réponses sous forme de boutons radio -->
                        <?php foreach ($reponses as $index => $reponse): ?>
                            <input type="radio" name="reponses<?= $question['question_id']; ?>" value="<?= $reponse; ?>" required>
                            <?= $reponse; ?><br>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Soumettre">
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
