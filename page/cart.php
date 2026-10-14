<?php
include("connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body>
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="menu-icon-default" src="../assets/icon/bars-solid-full.svg" alt="menu icon">
    <img class="menu-icon-active" src="../assets/icon/hamburger-green.svg" alt="menu icon active">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="recipes.php">RECIPES</a></li>
            <li><a href="#">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
<main>
    <h1 class="basket-title">Total : <?php echo formatNumber($_SESSION["total"] ?? 0);?> MGA</h1>
    <div class="products-grid">
        <?php
            $productIds = $_SESSION["productIds"] ?? [];
            $productNames = $_SESSION["productNames"] ?? [];
            $productQuantities = $_SESSION["productQuantities"] ?? [];
            $productPrices = $_SESSION["productPrices"] ?? [];

            for ($i = 0; $i < count($productIds); $i++) { 
        ?>
        <div class="cart-product-card">
            <a href="product.php?id=<?php echo $productIds[$i]?>"><img class="cart-product-image" src="../assets/img/<?php echo $productIds[$i];?>.png" alt="<?php echo $productNames[$i] ?? '';?></"></a>
            <p class="product-name"><?php echo $productNames[$i] ?? '';?></p>
            <p class="product-quantity"><?php echo formatNumber($productQuantities[$i] ?? 0);?> kg</p>
            <div class="cart-summary">
                <p><?php echo formatNumber($productPrices[$i] ?? 0);?> MGA</p>
                <a href="#"><img class="cart-icon" src="../assets/img/shopping-bag.png" alt="basket"></a>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <a href="empty-cart.php" class="empty-cart-button">EMPTY THE BASKET</a>
</main>
</body>
</html>