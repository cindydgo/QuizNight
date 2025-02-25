<?php
include('../config/config.php');

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_answers = array();
    $score = 0; // Initialise le score

    // Récupère les réponses de l'utilisateur
    foreach ($_POST as $key => $value) {
        $user_answers[substr($key, 8)] = $value; // Extrait l'ID de la question
    }

    // Crée une chaîne avec les IDs des questions pour les utiliser dans la requête SQL
    $question_ids = implode(',', array_keys($user_answers));

    // Prépare une seule requête pour récupérer les questions et les réponses correctes
    $stmt = $pdo->prepare('SELECT questions.id AS question_id, questions.question, reponses.reponse AS correct_answer, reponses.is_correct 
        FROM questions
        LEFT JOIN reponses ON questions.id = reponses.question_id 
        WHERE questions.id IN (' . $question_ids . ') AND reponses.is_correct = 1
    ');
    $stmt->execute();

    // Récupère toutes les données en une seule fois (ce qui permet de sortir la boucle while du foreach)
    $questions = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $questions[$data['question_id']] = $data; // Stocke les résultats de la requête par question_id
    }

    // Parcours les réponses de l'utilisateur
    foreach ($user_answers as $question_id => $user_answer) {
        if (isset($questions[$question_id])) {
            // Récupère la question et la réponse correcte
            $data = $questions[$question_id];

            // Compare la réponse de l'utilisateur avec la bonne réponse
            if ($user_answer == $data['correct_answer']) {
                $score++; // Incrémente le score si la réponse est correcte
            }

            // Affiche les détails pour chaque question
            $results[] = [
                'question' => htmlspecialchars($data['question']),
                'user_answer' => htmlspecialchars($user_answer),
                'correct_answer' => htmlspecialchars($data['correct_answer']),
                'is_correct' => $user_answer == $data['correct_answer'] ? 'Vrai' : 'Faux'
            ];
        }
    }

    $total_questions = count($user_answers);
    $message = "Vous avez répondu correctement à $score questions sur $total_questions.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/style.css">
    <title>Résultats du Quiz</title>
</head>
<body>
    <header>
        <nav class="nav-bar">
            <i class="fa-solid fa-bars"></i>
            <a href="index.php" class="home-logo">
                <img src="../assets/logo.png" alt="logo" class="logo">
            </a>
            <ul>
                <li><a href="./includes/question.php">Questions</a></li>
                <li><a href="./includes/login.php">Mon compte</a></li>
                <li><a href="./includes/register.php">S'inscrire</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="results-section">
            <h1>Résultats</h1>

            <?php if (isset($results) && !empty($results)): ?>
                <div class="results-details">
                    <?php foreach ($results as $result): ?>
                        <div class="result">
                            <p><strong>Question :</strong> <?= $result['question']; ?></p>
                            <p><strong>Votre réponse :</strong> <?= $result['user_answer']; ?></p>
                            <p><strong>Bonne réponse :</strong> <?= $result['correct_answer']; ?></p>
                            <p><strong>Correcte :</strong> <?= $result['is_correct']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <p class="message"><strong><?= htmlspecialchars($message); ?></strong></p>
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
