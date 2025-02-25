<?php
include('./config/config.php');

// Récupère l'ID de la catégorie depuis l'URL
$category_id = $_GET['id'] ?? null;

if ($category_id) {
    // Récupère le nom de la catégorie en fonction de l'ID
    $stmt = $pdo->prepare('SELECT category_name FROM categories WHERE id = :category_id');
    $stmt->execute(['category_id' => $category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($category) {
        $category_name = $category['category_name'];
    } else {
        $category_name = 'Catégorie inconnue';
    }
} else {
    $category_name = 'Aucune catégorie sélectionnée';
}

if ($category_id) {
    // Récupère toutes les questions et leurs réponses sous forme de chaîne séparée par des virgules
    $stmt = $pdo->prepare('SELECT questions.id AS question_id, questions.question, GROUP_CONCAT(reponses.reponse ORDER BY reponses.id ASC) AS reponses
        FROM questions
        LEFT JOIN reponses ON questions.id = reponses.question_id
        WHERE questions.category_id = :category_id
        GROUP BY questions.id
    ');
    $stmt->execute(['category_id' => $category_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $questions = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/style.css">
    <title>Catégorie</title>
</head>
<body>
<header>
    <nav class="nav-bar">
        <i class="fa-solid fa-bars"></i>
        <a href="./index.php" class="home-logo">
            <img src="./assets/logo.png" alt="logo" class="logo">
        </a>
        <ul>
            <li>
                <a href="./includes/question.php">Questions</a>
            </li>
            <li>
                <a href="./includes/login.php">Mon compte</a>
            </li>
            <li>
                <a href="./includes/register.php">S'inscrire</a>
            </li>
        </ul>
    </nav>
</header>

<main>
    <section class="category_section">
        <h1>Catégorie: <?= htmlspecialchars($category_name); ?></h1>
        <?php if (!empty($questions)): ?>
            <form method="post" action="./includes/resultat.php" id="question_form">
                <?php foreach ($questions as $question): ?>
                    <div class="question-card">
                        <p class="question-title"><?= htmlspecialchars($question['question']); ?></p>
                        <?php if ($question['reponses']): ?>
                            <?php
                            // Convertit la chaîne des réponses séparées par des virgules en un tableau
                            $reponses = explode(',', $question['reponses']);
                            foreach ($reponses as $reponse): ?>
                                <input type="radio" name="reponses<?= $question['question_id']; ?>" value="<?= $reponse; ?>" required>
                                <?= htmlspecialchars($reponse); ?><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune réponse disponible pour cette question.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Soumettre">
            </form>
        <?php else: ?>
            <p>Aucune question disponible dans cette catégorie.</p>
        <?php endif; ?>
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
