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
    <img class="menu-icon-default" src="../assets/icon/bars-solid-full.svg" alt="menu icon">
    <img class="menu-icon-active" src="../assets/icon/hamburger-green.svg" alt="menu icon active">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="#">RECIPES</a></li>
            <li><a href="cart.php">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
<main>
<form method="GET" class="search-form">
    <input type="text" name="food" placeholder="Search for food" value="<?php echo isset($_GET['food']) ? htmlspecialchars($_GET['food']) : ''; ?>">
    <input type="submit" value="Validate">
</form>
<div class="recipe-grid">
    <?php
        function getRecipePageLimit(): int {
            return preg_match('/Android|iPhone|iPad|iPod|IEMobile|Opera Mini|Mobile/i', $_SERVER['HTTP_USER_AGENT'] ?? '') ? 4 : 8;
        }

        function fetchRandomMeals(int $count): array {
            $meals = [];

            for ($i = 0; $i < $count; $i++) {
                $url = "https://www.themealdb.com/api/json/v1/1/random.php";
                $json = @file_get_contents($url);
                $data = $json !== false ? json_decode($json, true) : null;

                if (isset($data['meals'][0])) {
                    $meals[] = $data['meals'][0];
                }
            }

            return $meals;
        }

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $search = isset($_GET['food']) ? trim($_GET['food']) : '';
        $limit = getRecipePageLimit();
        $allResults = [];

        if ($search !== '') {
            $url = "https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($search);
            $json = @file_get_contents($url);
            $data = $json !== false ? json_decode($json, true) : null;
            if (isset($data['meals'])) {
                $allResults = $data['meals'];
            }
        } else {
            $allResults = fetchRandomMeals(16);
        }

        $totalResults = count($allResults);
        $totalPages = max(1, (int) ceil($totalResults / $limit));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $limit;
        $pagedResults = array_slice($allResults, $offset, $limit);

        if ($totalResults === 0) {
            echo '<p>No recipe found.</p>';
        }

        foreach ($pagedResults as $meal) {
            $mealName = is_array($meal) && isset($meal['strMeal']) ? $meal['strMeal'] : 'Recipe';
            $mealThumb = is_array($meal) && isset($meal['strMealThumb']) ? $meal['strMealThumb'] : '';
            $mealId = is_array($meal) && isset($meal['idMeal']) ? $meal['idMeal'] : 0;
        ?>
        <div class="recipe-card-item">
            <a href="recipe-details.php?id=<?php echo $mealId; ?>"><img class="recipe-image" src="<?php echo $mealThumb; ?>" alt="<?php echo $mealName; ?>"></a>
            <p class="recipe-title"><?php echo $mealName; ?></p>
            <a class="recipe-link" href="recipe-details.php?id=<?php echo $mealId; ?>">SEE THE RECIPE</a>
        </div>
        <?php
        }
        ?>
</div>

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a class="pagination-button" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">PREVIOUS</a>
        <?php endif; ?>

        <?php if ($totalPages <= 2): ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="pagination-active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a class="pagination-button" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        <?php else: ?>
            <form method="GET" class="pagination-form">
                <?php foreach ($_GET as $key => $value): ?>
                    <?php if ($key !== 'page'): ?>
                        <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <select name="page" class="page-selector" onchange="this.form.submit()">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $i === $page ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a class="pagination-button" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">NEXT</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
</main>
</body>
</html>