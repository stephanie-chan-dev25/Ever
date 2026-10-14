<?php include("connection.php");?>
<?php
$id = $_GET["id"];
$sql = $conn->prepare("SELECT * FROM food WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food - Ever</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/js/script.js" defer=""></script>
</head>
<body class="content">
<nav>
    <img src="../assets/img/logo.svg" alt="Ever">
    <img class="menu-icon-default" src="../assets/icon/bars-solid-full.svg" alt="menu icon">
    <img class="menu-icon-active" src="../assets/icon/hamburger-green.svg" alt="menu icon active">
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="recipes.php">RECIPES</a></li>
            <li><a href="cart.php">BASKET</a></li>
            <li><a href="../index.php#contact">CONTACTS</a></li>
        </ul>
</nav>
    <a class="back" href="../index.php">
        <img class="back-icon-default" src="../assets/icon/arrow-left-solid-full.svg" alt="back">
        <img class="back-icon-active" src="../assets/icon/arrow-green.svg" alt="back active">
    </a>
    <img class="main-image" src="../assets/img/<?php echo $id;?>.png" alt="<?php echo $row["name"]?>">
<div class="product-content">
    <h1><?php echo $row["name"]?></h1>
    <div class="product-summary">
        <p><?php echo $row["quantity"]?> kg</p>
        <p><?php echo formatNumber($row["price"])?> MGA</p>
    </div>
    <div class="nutrient-list">
        <?php
        $sql2 = $conn->prepare("SELECT n.name AS nutrient, c.quantity
        FROM contains c
        JOIN nutrient n ON c.nutrient_id = n.id
        WHERE c.food_id = ?");
        $sql2->bind_param("i", $id);
        $sql2->execute();
        $result2 = $sql2->get_result();
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
        ?>
            <div class="nutrient-item">
                <p><?php echo $row2['nutrient'];?></p>
                <p><?php echo formatNumber($row2['quantity']);?> g</p>
            </div>
        <?php
            }
        } else {
            echo "No nutrient found for this food.";
        }
        ?>
    </div>
</div>
</body>
</html>