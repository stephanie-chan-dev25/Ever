<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe details - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <link rel="stylesheet" href="../assets/css/recipe-details.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body class="content">
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="black-hamburger" src="../assets/icon/bars-solid-full.svg" alt="menu hamburger">
    <img class="green-hamburger" src="../assets/icon/hamburger-vert.svg" alt="menu hamburger">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="recipes.php">RECIPES</a></li>
            <li><a href="cart.php">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
    <a class="back" href="recipes.php">
        <img class="black-back" src="../assets/icon/arrow-left-solid-full.svg" alt="back">
        <img class="green-back" src="../assets/icon/fleche-vert.svg" alt="back">
    </a>
    <?php
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . $id;
        $json = file_get_contents($url);
        $data = json_decode($json, true);
    
        if (isset($data['meals'][0])) {
            $details = $data['meals'][0];
    ?>
    <img class="main-image" src="<?= $details['strMealThumb'] ?>">
    <h1><?= $details['strMeal'] ?></h1>
    <p class="instructions" ><?= nl2br($details['strInstructions']) ?></p>
    <?php
        }
    }
    ?>
</body>
</html>