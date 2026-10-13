<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/recipes.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body>
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="black-hamburger" src="../assets/icon/bars-solid-full.svg" alt="menu hamburger">
    <img class="green-hamburger" src="../assets/icon/hamburger-vert.svg" alt="menu hamburger">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="#">RECIPES</a></li>
            <li><a href="cart.php">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
<main>
<form method="GET" class="search-form">
    <input type="text" name="food" placeholder="Search for food">
    <input type="submit" value="Validate">
</form>
<div class="recipe-grid">
    <?php
        $results = [];
        if (isset($_GET['food'])) {
            $foodName = strtolower(trim($_GET['food']));
            if (!empty($foodName)) {
                $url = "https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($foodName);
                $json = file_get_contents($url);
                $data = json_decode($json, true);
        
                if (isset($data['meals'])) {
                    $results = $data['meals'];
                }
            } else {
                ?>
                <p><?php echo "Food not recognized";?></p>
                <?php
            }
        }
        ?>
        <?php
            foreach ($results as $meal) {
        ?>
        <div class="recipe-card">
            <a href="#"><img class="recipe-image" src="<?php echo $meal['strMealThumb'];?>" alt="<?php echo $meal['strMeal'];?>"></a>
            <p class="recipe-title"><?php echo $meal['strMeal'];?></p>
            <a class="recipe-link" href="recipe-details.php?id=<?php echo $meal['idMeal'];?>">SEE THE RECIPE</a>
        </div>
        <?php
        }
        ?>
</div>
</main>
</body>
</html>