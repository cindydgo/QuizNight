<?php
include("./config/config.php");

session_start();

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC); 

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
    <title>Quiznight</title>
</head>
<body>
    <header>
        <nav class="nav-bar">
            <i class="fa-solid fa-bars"></i>
            <a href="index.php" class="home-logo">
                <img src="./assets/logo.png" alt="logo" class="logo">
            </a>
            <ul>
                <li>
                    <a href="./includes/question.php">
                        Questions
                    </a>
                </li>
                <li>
                    <a href="./includes/login.php">
                        Mon compte
                    </a>
                </li>
                <li>
                    <a href="./includes/register.php">
                        S'inscrire
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="main_section">
            <h1>
                <i class="fa-solid fa-question"></i>
                Quiznight
                <i class="fa-solid fa-question"></i>
            </h1>
            <h3 class="choose-category">Choisir la catégorie :</h3>
            <div name="categories" id="categories">
                <?php 
                    foreach ($categories as $category) {
                    echo "<a href='categorie.php?id={$category['id']}' class='categorie-card'>{$category['category_name']}</a>";
                    } 
                ?>
            </div>
        </section>
    <main>
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